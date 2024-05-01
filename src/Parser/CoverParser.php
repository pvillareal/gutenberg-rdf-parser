<?php

namespace Gutenberg\Parser;

use Gutenberg\Models\BookCover;
use Gutenberg\Models\GutenbergBook;
use Imagick;
use ImagickDraw;

class CoverParser
{

    public function __construct()
    {
        
    }

    public function __invoke(Imagick $img, GutenbergBook $book) : void
    {
        $draw = new ImagickDraw();
        $draw->setFontSize(10);

        $bookCover = new BookCover($book);

        $row = 32;
        if ($bookCover->hasSubtitle()) {
            $title = $bookCover->getTitle();
            $draw->setFont('DejaVu-Sans-Bold');
            $img->annotateImage($draw, 10, 32, 0, $title);

            $draw->setFont('DejaVu-Sans');
            $subTitle = $bookCover->getSubtitle();
            $str = wordwrap($subTitle, 30,PHP_EOL);
            $str_array = explode(PHP_EOL, $str);
            $y = $row;
            foreach($str_array as $line) {
                $y = $y+12;
                $img->annotateImage( $draw, 10, $y, 0, $line);
            }
        } else {
            $draw->setFont('DejaVu-Sans-Bold');
            $str = $bookCover->getTitle();
            $str = wordwrap($str, 30,PHP_EOL);
            $str_array = explode(PHP_EOL, $str);
            $y = $row;
            foreach($str_array as $line) {
                $img->annotateImage( $draw, 10, $y, 0, $line);
                $y = $y+12;
            }
        }

        $draw->setFont('DejaVu-Sans');
        $y = 68 + 24;

        $authorsDisplay = $bookCover->getAuthors();

        foreach($authorsDisplay as $line) {
            $y += 11;
            $img->annotateImage( $draw, 10, $y, 0, $line);
        }
        $img->annotateImage( $draw, 10, 295, 0, "Project Guttenberg");
        $img->writeImage("/app/tmp/{$book->id}.medium.cover.jpg");
        $img->cropThumbnailImage(66, 99);
        $img->writeImage("/app/tmp/{$book->id}.small.cover.jpg");
        $draw->clear();
    }

}