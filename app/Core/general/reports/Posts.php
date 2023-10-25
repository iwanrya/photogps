<?php

namespace App\Core\general\reports;

use App\Core\App;
use App\Models\Post;
use DateTime;
use Illuminate\Support\Facades\File;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Posts
{

    /**
     * @param string $filepath
     * @param Post $post
     * @param string $dest_filepath
     */
    static function generate($filepath, $post, $dest_filepath)
    {

        $reader = new XlsxReader();
        $spreadsheet = $reader->load($filepath);

        $sheet = $spreadsheet->getSheetByName('main');

        self::postInformation($sheet, $post);

        // copy sheets when post has photo more than one
        foreach ($post->postPhoto as $index => $postPhoto) {
            if ($index > 0) {
                $num = $index + 1;

                $clonedWorksheet = clone $spreadsheet->getSheetByName('写真');
                $clonedWorksheet->setTitle("写真-{$num}");
                $spreadsheet->addSheet($clonedWorksheet);
            }
        }

        // mapping each sheet for each photo
        foreach ($post->postPhoto as $index => $postPhoto) {
            $num = $index + 1;

            $sheetName = "写真" . (($index > 0) ? "-{$num}" : "");
            $sheet = $spreadsheet->getSheetByName($sheetName);
            self::postPhoto($sheet, $postPhoto);
        }

        $writer = new XlsxWriter($spreadsheet);
        $writer->save($dest_filepath);
    }

    private static function postInformation($sheet, $post)
    {
        $sheet->setCellValueExplicit("H3", $post->created_at_formatted, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("H4", $post->photographer, DataType::TYPE_STRING);

        $customer_name = $post->customer ? $post->customer->name : "";
        $sheet->setCellValueExplicit("H5", $customer_name, DataType::TYPE_STRING);

        $project_name = $post->project ? $post->project->name : "";
        $sheet->setCellValueExplicit("H6", $project_name, DataType::TYPE_STRING);

        $area_name = $post->area ? $post->area->name : "";
        $sheet->setCellValueExplicit("H7", $area_name, DataType::TYPE_STRING);

        $status = $post->statusItem ? $post->statusItem->name : "";
        $sheet->setCellValueExplicit("H8", $status, DataType::TYPE_STRING);

        $sheet->setCellValueExplicit("I9", $post->longitude, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("O9", $post->latitude, DataType::TYPE_STRING);

        $base_row = 11;
        foreach ($post->postComment as $index => $comment) {
            $sheet->setCellValueExplicit("C" . ($base_row + ($index * 3)), "{$comment->createUser->name} ({$comment->created_at_formatted})", DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D" . ($base_row + ($index * 3) + 1), $comment->comment, DataType::TYPE_STRING);
        }
    }

    private static function postPhoto($sheet, $postPhoto)
    {
        $sheet->setCellValueExplicit("F2", $postPhoto->shoot_datetime_formatted, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("H3", $postPhoto->longitude, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("N3", $postPhoto->latitude, DataType::TYPE_STRING);

        $image_path = App::photo_mobile_noexif_file_location() . $postPhoto->getRawOriginal('image');

        $drawing = new Drawing();
        $drawing->setName($postPhoto->getRawOriginal('image'));
        $drawing->setPath($image_path); // put your path and image here
        $drawing->setCoordinates('C5');
        $drawing->setHeight(500);
        $drawing->setWidth(500);
        $drawing->setWorksheet($sheet);
    }
}
