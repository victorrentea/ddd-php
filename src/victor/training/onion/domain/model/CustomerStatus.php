<?php

namespace victor\training\onion\domain\model;

enum CustomerStatus
{
    case DRAFT;
    case VALIDATED;
    case ACTIVE;
    case DELETED;
}
