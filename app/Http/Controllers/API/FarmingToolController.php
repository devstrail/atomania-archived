<?php

namespace App\Http\Controllers\API;

use App\Models\FarmingTool;

class FarmingToolController extends BaseCrudController {

    public function __construct()
    {
        parent::__construct("FarmingTool", FarmingTool::class, FarmingTool::validations());
    }
}
