<?php

namespace victor\training\onion\be\domain\model;

enum CustomerStatus
{
    case DRAFT;
    case VALIDATED;
    case ACTIVE;
    case DELETED;
}
