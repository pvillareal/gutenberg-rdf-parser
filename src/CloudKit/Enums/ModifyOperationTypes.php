<?php

namespace Gutenberg\CloudKit\Enums;

enum ModifyOperationTypes : string
{
    case CREATE = "create";
    case UPDATE = "update";
    case DELETE = "delete";
    case REPLACE = "replace";
    case FORCE_UPDATE = "forceUpdate";
    case FORCE_REPLACE = "forceReplace";
    case FORCE_DELETE = "forceDelete";

}
