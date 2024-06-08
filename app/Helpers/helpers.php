<?php

function isJsonField(string $field, array $jsonFields): bool
{
    return in_array($field, $jsonFields);
}

