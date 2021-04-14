<?php


namespace Iwindy\LaravelPermission;


class Permission
{
    public static $auth_nodes = [];

    /**
     * @return array
     */
    public function getAuthNodesTree()
    {
        $notes = $this->generateFullNodes();
        $tree = [];
        foreach ($notes as $key => $value) {
            if (strripos($key, '.')) {
                $pkey = substr($key, 0, strripos($key, '.'));
                $notes[$pkey]['children'][] = &$notes[$key];
            } else {
                $tree[] = &$notes[$key];
            }
        }
        return $tree;
    }

    /**
     * @return array
     */
    public function generateFullNodes()
    {
        $notes = self::$auth_nodes;
        $new_notes = [];
        foreach ($notes as $key => $item) {
            $path = explode('.', $key);
            $level_count = count($path);
            $str = '';
            foreach ($path as $k => $v) {
                $name = lang('permissions.' . $v);
                if ($level_count != $k + 1) {
                    $str = trim($str . '.' . $v, '.');
                    $new_notes[$str]['path'] = $str;
                    $new_notes[$str]['name'] = $name;
                } else {
                    $new_notes[$key] = [
                        'path'       => $key,
                        'name'       => $name,
                        'permission' => $item['permission']
                    ];
                }
            }
        }
        return $new_notes;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getNodes()
    {
        return collect(self::$auth_nodes)->pluck('permission');
    }
}
