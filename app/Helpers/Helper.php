<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    public static function menu($menus, $parent_id = 0, $char = '')
    {
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $html .= '
                <tr>
                <th>' . $menu->id . '</th>
                <th>' . $menu->name . '</th>
                <th>' . self::active($menu->active) . '</th>
                <th>' . $menu->updated_at . '</th>
                <th>' .
                    '<a class="btn btn-primary btn-sm" href="/admin/menus/edit/' . $menu->id . '">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-danger btn-sm" href="#" onclick="removeRow(' . $menu->id . ',\'/admin/menus/destroy\')">
                        <i class="fas fa-trash"></i>
                    </a>
                    '
                    . '</th>
                </tr>';

                unset($menu[$key]);

                $html .= self::menu($menus, $menu->id, '--');
            }
        }
        return $html;
    }

    public static function active($active = 0)
    {
        return $active == 0 ? '<span class="btn btn-danger btn-sx">NO</span>' : '<span class="btn btn-success btn-sx">YES</span>';
    }

    public static function menus($menus, $parent_id = 0): string
    {
        #d($menus);
        $html = '';
        foreach ($menus as $menu) {
            if ($menu->parent_id == $parent_id) {
                $html .= '
                    <li>
                        <a href="/danh-muc/' . $menu->id . '-' . Str::slug($menu->name, '-') . '.html">' . $menu->name . '</a>
                    ';

                //unset($menus[$key]);

                if (self::isChild($menus, $menu->id)) {
                    $html .= '<ul class="sub-menu">';
                    $html .= self::menus($menus, $menu->id);
                    $html .= '</ul>';
                }

                $html .= '</li>';
            }
        }

        return $html;
    }

    public static function isChild($menus, $id): bool
    {
        foreach ($menus as  $menu) {
            if ($menu->parent_id == $id) {
                return true;
            }
        }

        return false;
    }

    public static function price($price = 0, $priceSale = 0)
    {
        if ($priceSale != 0) {
            return number_format($priceSale);
        }
        if ($price != 0) {
            return number_format($price);
        }

        return '<a href="/lien-he.html">Liên hệ</a>';
    }

    public static function monthYearFormat($created)
    {
        $result = '';
        $month = substr($created, 5, 2);
        switch ($month) {
            case 1:
                $result = 'Jan';
                break;
            case 2:
                $result = 'Feb';
                break;
            case 3:
                $result = 'Mar';
                break;
            case 4:
                $result = 'Apr';
                break;
            case 5:
                $result = 'May';
                break;
            case 6:
                $result = 'June';
                break;
            case 7:
                $result = 'July';
                break;
            case 8:
                $result = 'Aug';
                break;
            case 9:
                $result = 'Sep';
                break;
            case 10:
                $result = 'Oct';
                break;
            case 11:
                $result = 'Nov';
                break;
            case 12:
                $result = 'July';
                break;
        }

        return $result . ' ' . substr($created, 0, 4);
    }
}
