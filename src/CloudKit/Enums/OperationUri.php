<?php

namespace Gutenberg\CloudKit\Enums;

enum OperationUri : string
{
    case MODIFY_RECORDS = "records/modify";
    case UPLOAD_ASSETS = "assets/upload";

}