<?php

namespace App\DataMappers;

class MenuDataMapper implements DataMapper
{
    /**
     * Map data
     *
     * @param array $data
     * @return array
     */
    public function mapData(array $data): array
    {
        $emptyJsonField = json_encode([]);
        $mappedData = [
            'title' => $emptyJsonField,
            'description' => $emptyJsonField,
            'styles' => $emptyJsonField,
        ];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value['structure'] = array_keys($value);
                $mappedData[$key] = json_encode($value, JSON_HEX_QUOT);
            } else {
                $mappedData[$key] = $value  ;
            }
        }

        return $mappedData;
    }
}
