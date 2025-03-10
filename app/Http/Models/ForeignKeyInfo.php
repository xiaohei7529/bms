<?php

namespace App\Http\Models;

class ForeignKeyInfo
{
    private  $columnName;
    private  $referenceTable;
    private  $referenceColumn;

    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function setColumnName(string $columnName): void
    {
        $this->columnName = $columnName;
    }

    public function getReferenceTable(): string
    {
        return $this->referenceTable;
    }

    public function setReferenceTable(string $referenceTable): void
    {
        $this->referenceTable = $referenceTable;
    }

    public function getReferenceColumn(): string
    {
        return $this->referenceColumn;
    }

    public function setReferenceColumn(string $referenceColumn): void
    {
        $this->referenceColumn = $referenceColumn;
    }
}