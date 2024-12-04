<?php

namespace App\Imports;

use App\Models\book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new book([
            'title' => $row['title'],
            'author' => $row['author'],
            'year' => $row['year'],
            'publisher' => $row['publisher'],
            'city' => $row['city'],
            'cover' => 'null',
            'bookshelf_id' => $row['bookshelf'],
        ]);
    }
}
