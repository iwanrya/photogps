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

        $sheet = $spreadsheet->getSheetByName('基本情報');

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

        $customer_name = $post->company ? $post->company->name : "";
        $sheet->setCellValueExplicit("H5", $customer_name, DataType::TYPE_STRING);

        $project_name = $post->project ? $post->project->name : "";
        $sheet->setCellValueExplicit("H6", $project_name, DataType::TYPE_STRING);

        $area_name = $post->area ? $post->area->name : "";
        $sheet->setCellValueExplicit("H7", $area_name, DataType::TYPE_STRING);

        $status = $post->statusItem ? $post->statusItem->name : "";
        $sheet->setCellValueExplicit("H8", $status, DataType::TYPE_STRING);

        $firstRow = 10;
        $lastRow = 0;

        $index = 0;
        for ($i = count($post->postComment) - 1; $i >= 0; $i--) {
            $comment = $post->postComment[$i];
            $firstRow = $lastRow == 0 ? $firstRow : ($lastRow + 1); // lastRow == 0 means first comment
            $lastRow = $firstRow;

            $styleArray = array(
                'borders' => array(
                    'outline' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => array('argb' => 'FF000000'),
                    ),
                ),
            );

            $sheet->mergeCells("C{$firstRow}:V{$firstRow}");
            $sheet->setCellValueExplicit("C" . $firstRow, "{$comment->createUser->name} ({$comment->created_at_formatted})", DataType::TYPE_STRING);

            // get comment per line
            $lineComments = preg_split('/\r\n|\r|\n/', $comment->comment);

            // draw line comment and merge the cells
            foreach ($lineComments as $commentIndex => $lineComment) {
                $commentRow = ($firstRow + 1 + $commentIndex);
                $lastRow = $commentRow;

                $sheet->mergeCells("D{$commentRow}:V{$commentRow}");
                $sheet->setCellValueExplicit("D" . $commentRow, $lineComment, DataType::TYPE_STRING);
            }
            $lastRow++; // extra one row for space

            $sheet->getStyle("B{$firstRow}:V{$lastRow}")->applyFromArray($styleArray);

            $index++;
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
