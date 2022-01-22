<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\helpers;

abstract class Paginator
{
    protected float $totalPages;
    protected float $offSet;
    protected int $page;

    public function __construct(float $totalRecords, int $recordsPerPage, int $page)
    {
        $this->totalPages = ceil($totalRecords / $recordsPerPage);
        $this->page = filter_var($page, FILTER_VALIDATE_INT);
        $this->offSet = $recordsPerPage * ($this->page - 1);
    }

    public function getOffSet(): int
    {
        return (int)$this->offSet;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getTotalPages(): int
    {
        return (int)$this->totalPages;
    }
}
