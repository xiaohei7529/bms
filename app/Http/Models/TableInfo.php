<?php

namespace App\Http\Models;

class TableInfo
{
    private  $tableName;
    private  $columns = [];
    private  $primaryKeys = [];
    private  $foreignKeys = [];
    private  $comment = null;

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    public function getPrimaryKeys(): array
    {
        return $this->primaryKeys;
    }

    public function setPrimaryKeys(array $primaryKeys): void
    {
        $this->primaryKeys = $primaryKeys;
    }

    public function getForeignKeys(): array
    {
        return $this->foreignKeys;
    }

    public function setForeignKeys(array $foreignKeys): void
    {
        $this->foreignKeys = $foreignKeys;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }
}