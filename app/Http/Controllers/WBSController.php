<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WBSNode;
use App\Models\Product;

class WBSController extends Controller
{
    public function index()
    {
        $wbsNodes = WBSNode::with('product')->get();
        return view('wbs.index', compact('wbsNodes'));
    }

    public function show(WBSNode $wbsNode)
    {
        $wbsNode->load('product', 'parent', 'children');
        return view('wbs.show', compact('wbsNode'));
    }
}
