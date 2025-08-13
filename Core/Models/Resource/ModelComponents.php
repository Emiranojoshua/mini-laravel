<?php

namespace Core\Models\Resource;



trait ModelComponents
{
    private function filterFillable(array $data)
    {
        if (empty($this->fillable)) {
            return $data; // If no fillable defined, allow all
        }

        return array_intersect_key($data, array_flip($this->fillable));
    }

    private function addFields(array $fields, array $filteredData)
    {   
        foreach ($fields as $value) {
            if (!isset($filteredData[$value[0]])) {
                $filteredData[$value[0]] = $value[1];
            }
        }
        return $filteredData;
    }
}
