<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class data_manager
{
    public static function renameFile($file,...$path) : string
    {
        return hash('sha256', file_get_contents($file->getRealPath())) . '.' . $file->getClientOriginalExtension();
    }

    public static function accessRole(): array
    {
        return [
          "isAdmin"=> true,
          "permission"=> [
              "artikel"=>[
                  "write"=>false,
                  "need_verification"=>true
              ],
              "pengumuman"=>[
                  "write"=>false,
                  "need_verification"=>true
              ],
              "event"=>[
                  "write"=>false,
                  "need_verification"=>true
              ],
              "berita"=>[
                  "write"=>false,
                  "need_verification"=>true
              ]
          ],
            "customPermission"=> [],
        ];
    }

    public static function array2base($data)
    {
        $jsonData = json_encode($data);
        return base64_encode($jsonData);
    }

    public static function base2array($data)
    {
        $base64 = base64_decode($data);
        return json_decode($base64);
    }

    public static function generate_accessrole() {
        $role = data_manager::accessRole();
        $role["isAdmin"] = true;

        $base = data_manager::array2base($role);
        return ["base"=>$base,"dec"=>data_manager::base2array($base)];
    }
}
