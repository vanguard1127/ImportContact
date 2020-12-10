<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\CustomAttribute;

class ContactController extends Controller
{
    public function import(Request $request)
    {
        $csv = $request->csv;
        $map = $request->map;
        $column_header = $csv[0];
        $skipped_count = 0;
        for($i = 1 ; $i < count($csv); $i++)
        {
            $csv_row = $csv[$i];
            $contact = new Contact();
            foreach($map as $index=>$map_item) {
                $contact[$map_item] = $csv_row[$index];
                unset($csv_row[$index]);
            }
            try {
                $contact->save();
            }
            catch (\Exception $e)
            {
                $skipped_count++;
                continue;
            }

            foreach($csv_row as $index=>$row_item) {
                $custom_attribute = new CustomAttribute();
                $custom_attribute->contact_id = $contact->id;
                $custom_attribute->key = $column_header[$index];
                $custom_attribute->value = $row_item;
                try {
                    $custom_attribute->save();
                }
                catch (\Exception $e)
                {
                    continue;
                }
            }

        }
        return response()->json(['success' => ['msg' => 'Success to Import', 'skip_count' => $skipped_count]])->setStatusCode(200);
    }
}
