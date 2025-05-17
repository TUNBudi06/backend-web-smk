<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ProfileData",
 *     type="object",
 *
 *     @OA\Property(
 *     property="id_profile",
 *     type="integer",
 *     example=1
 *     ),
 *     @OA\Property(
 *     property="profile_name",
 *     type="string",
 *     example="Komite Sekolah"
 *    ),
 *     @OA\Property(
 *       property="name_data",
 *     type="string",
 *     example="name of file data if type = data"
 *     ),
 *     @OA\Property(
 *     property="type_data",
 *     type="string",
 *     example="text,'url','file'"
 *    ),
 *     @OA\Property(
 *     property="profile_data",
 *     type="string",
 *     example="https://..."
 *   ),
 *     @OA\Property(
 *     property="icon_type",
 *     type="string",
 *     example="Profile"
 *   ),
 *     )
 * */
class profileController extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $ret['id_profile'] = $this->id_link;
        if (in_array($this->type, ['url', 'file'])) {
            $ret['profile_name'] = $this->title;
            $ret['name_data'] = $this->description ? $this->description : 'URL';
            $ret['type_data'] = $this->type;
            $ret['profile_data'] = $this->url;
        } else {
            $ret['profile_name'] = $this->title;
            if ($this->id_link == 8) {
                $ret['profile_image'] = asset($this->url);
                $ret['profile_data'] = $this->description;
            } elseif ($this->id_link == 9) {
                $ret['profile_image'] = asset($this->url);
                $ret['profile_data'] = $this->description;
            }
            else {
                $ret['name_data'] = 'Text';
                $ret['profile_data'] = $this->description;
                $ret['type_data'] = 'text';
            }
        }

        $ret['icon_type'] = 'Profile';

        return $ret;
    }
}
