<?php

namespace App\Enum;

enum OperationAttribute: string
{
    case GET_ITEM = 'GET_ITEM';
    case GET_COLLECTION = 'GET_COLLECTION';
    case POST_COLLECTION = 'POST_COLLECTION';
    case PUT_ITEM = 'PUT_ITEM';
    case PATCH_ITEM = 'PATCH_ITEM';
    case DELETE_ITEM = 'DELETE_ITEM';
}
