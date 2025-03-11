<?php

namespace App\Service;

use App\Http\Models\TableInfo;
use App\Http\Models\ColumnInfo;
use App\Http\Models\ForeignKeyInfo;
// use PHPSQLParser\PHPSQLParser;
use PHPSQLParser\PHPSQLParser;

// use Psr\Log\LoggerInterface;

class SqlParserService
{
    // private LoggerInterface $logger;
    private  $sqlParser;

    public function __construct()
    {
        // $this->logger = $logger;
        $this->sqlParser = new PHPSQLParser();
    }

    /**
     * 解析SQL并提取表信息
     * 
     * @param string $sql 原始SQL语句
     * @return array 表信息列表
     */
    public function parseSql(string $sql): array
    {
        $tables = [];
        
        try {
            // $this->logger->info("开始解析SQL: {$sql}");
            
            // 预处理SQL，移除UNIQUE INDEX语句
            $processedSql = $this->preprocessSql($sql);
            
            // 分割多个SQL语句
            $statements = $this->splitSqlStatements($processedSql);
            // $this->logger->info("成功解析SQL语句，共有" . count($statements) . "条语句");
            
            foreach ($statements as $statement) {
                // $this->logger->debug("处理语句: {$statement}");
                
                // 检查是否是CREATE TABLE语句
                if (stripos(trim($statement), 'CREATE TABLE') === 0) {
                    $parsed = $this->sqlParser->parse($statement);
                    
                    if (isset($parsed['CREATE']) && isset($parsed['TABLE'])) {
                        $tableName = $this->getTableName($parsed);
                        // $this->logger->info("解析CREATE TABLE语句: {$tableName}");
                        
                        $tableInfo = $this->parseCreateTable($parsed);
                        $tables[] = $tableInfo;
                    }
                }
            }
            
            // $this->logger->info("SQL解析完成，共解析出" . count($tables) . "个表");
            return $tables;
            
        } catch (\Exception $e) {
            // $this->logger->error("SQL解析错误: " . $e->getMessage());
            throw new \RuntimeException("SQL语法错误: " . $e->getMessage());
        }
    }
    
    /**
     * 预处理SQL，移除UNIQUE INDEX语句
     */
    private function preprocessSql(string $sql): string
    {
        $lines = explode("\n", $sql);
        $processedSql = '';
        
        foreach ($lines as $line) {
            // 跳过包含UNIQUE INDEX的行
            if (stripos(trim($line), 'UNIQUE INDEX') === false) {
                $processedSql .= $line . "\n";
            }
        }
        
        return $processedSql;
    }
    
    /**
     * 分割多个SQL语句
     */
    private function splitSqlStatements(string $sql): array
    {
        // 简单实现，使用分号分隔并移除空语句
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        pd($statements);
        return $statements;
    }
    
    /**
     * 从解析的SQL中获取表名
     */
    private function getTableName(array $parsed): string
    {
        if (isset($parsed['TABLE']['no_quotes']['parts'][0])) {
            return $parsed['TABLE']['no_quotes']['parts'][0];
        }
        
        if (isset($parsed['TABLE']['base_expr'])) {
            return trim($parsed['TABLE']['base_expr'], '`');
        }
        
        return 'unknown_table';
    }
    
    /**
     * 解析CREATE TABLE语句
     */
    private function parseCreateTable(array $parsed): TableInfo
    {
        $tableInfo = new TableInfo();
        $tableName = $this->getTableName($parsed);
        $tableInfo->setTableName($tableName);
        
        $columns = [];
        $primaryKeys = [];
        $foreignKeys = [];
        
        // 解析列定义
        // $this->logger->debug("开始解析表{$tableName}的列定义");
        
        if (isset($parsed['CREATE']['table']['create-def']['sub_tree'])) {
            $definitions = $parsed['CREATE']['table']['create-def']['sub_tree'];
            
            foreach ($definitions as $def) {
                if (isset($def['column-name'])) {
                    // 解析列
                    $columnInfo = $this->parseColumnDefinition($def);
                    $columns[] = $columnInfo;
                    
                    // 检查是否是主键
                    if ($this->isPrimaryKey($def)) {
                        $primaryKeys[] = $columnInfo->getName();
                        // $this->logger->info("找到主键: {$tableName}.{$columnInfo->getName()}");
                    }
                    
                } elseif (isset($def['constraint']) && stripos($def['constraint'], 'FOREIGN KEY') !== false) {
                    // 解析外键
                    $fkInfo = $this->parseForeignKey($def);
                    $foreignKeys[] = $fkInfo;
                    // $this->logger->info("找到外键: {$tableName}.{$fkInfo->getColumnName()} -> {$fkInfo->getReferenceTable()}.{$fkInfo->getReferenceColumn()}");
                }
            }
        }
        
        // 提取表注释
        $tableComment = $this->extractTableComment($parsed);
        $tableInfo->setComment($tableComment);
        // $this->logger->info("表{$tableName}的注释: {$tableComment}");
        
        $tableInfo->setColumns($columns);
        $tableInfo->setPrimaryKeys($primaryKeys);
        $tableInfo->setForeignKeys($foreignKeys);
        
        // $this->logger->info("表{$tableName}解析完成: " . count($columns) . "列, " . 
                        //   count($primaryKeys) . "个主键, " . count($foreignKeys) . "个外键");
        
        return $tableInfo;
    }
    
    /**
     * 解析列定义
     */
    private function parseColumnDefinition(array $def): ColumnInfo
    {
        $columnInfo = new ColumnInfo();
        $columnInfo->setName($def['column-name']);
        
        if (isset($def['column-type'])) {
            $columnInfo->setType($def['column-type']);
        }
        
        $columnInfo->setNullable(true); // 默认可为空
        
        // 检查列约束
        if (isset($def['options'])) {
            foreach ($def['options'] as $option) {
                if (strtoupper($option) === 'NOT NULL') {
                    $columnInfo->setNullable(false);
                } elseif (stripos($option, 'COMMENT') !== false) {
                    // 提取列注释
                    $comment = $this->parseQuotedString($option);
                    $columnInfo->setComment($comment);
                    // $this->logger->info("列{$columnInfo->getName()}的注释: {$comment}");
                }
            }
        }
        
        return $columnInfo;
    }
    
    /**
     * 判断列是否是主键
     */
    private function isPrimaryKey(array $def): bool
    {
        if (isset($def['options'])) {
            foreach ($def['options'] as $option) {
                if (strtoupper($option) === 'PRIMARY KEY') {
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * 解析外键定义
     */
    private function parseForeignKey(array $def): ForeignKeyInfo
    {
        $fkInfo = new ForeignKeyInfo();
        
        if (isset($def['references']['column'])) {
            $fkInfo->setColumnName($def['references']['column']);
        }
        
        if (isset($def['references']['table'])) {
            $fkInfo->setReferenceTable($def['references']['table']);
        }
        
        if (isset($def['references']['reference'])) {
            $fkInfo->setReferenceColumn($def['references']['reference']);
        }
        
        return $fkInfo;
    }
    
    /**
     * 提取表注释
     */
    private function extractTableComment(array $parsed): string
    {
        if (isset($parsed['TABLE']['table_options'])) {
            foreach ($parsed['TABLE']['table_options'] as $option) {
                if (isset($option['option_type']) && strtoupper($option['option_type']) === 'COMMENT') {
                    return $this->parseQuotedString($option['option_value']);
                }
            }
        }
        
        return $this->getTableName($parsed);
    }
    
    /**
     * 解析带引号的字符串
     */
    private function parseQuotedString(string $input): string
    {
        // 匹配单引号或双引号包裹的内容
        if (preg_match('/^[\'"](.*)[\'"]\s*$/', $input, $matches)) {
            return $matches[1];
        }
        
        // 如果未匹配到完整引号，尝试直接处理
        return preg_replace('/^[\'"]|[\'"]$/', '', $input);
    }
}