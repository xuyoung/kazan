<?php
namespace App\KaZanApp\ExpressFee\Controllers;

use Illuminate\Http\Request;
use App\KaZanApp\Base\Controller;
use Illuminate\Support\Facades\DB;

/**
 * 快递费 controller ，实现快递费管理菜单的所有内容，以及所有和快递费相关的功能实现
 * 这个类，用来：1、验证request；2、组织数据；3、调用service实现功能；[4、组织返回值]
 *
 * @author
 *
 * @since
 */
class ExpressFeeController extends Controller
{
    public function __construct(
        Request $request
    ) {
        parent::__construct();
        $this->expressFeeService = app('App\KaZanApp\ExpressFee\Services\ExpressFeeService');
        $this->expressFeeRequest = app('App\KaZanApp\ExpressFee\Requests\ExpressFeeRequest');
        $this->formFilter($request, $this->expressFeeRequest);
        $this->request = $request;
    }

    public function getExpressFeeList()
    {
        $result = $this->expressFeeService->getExpressFeeList($this->request->all());
        return $this->returnResult($result);
    }

    public function addExpressFee()
    {
        $result = $this->expressFeeService->addExpressFee($this->request->all());
        return $this->returnResult($result);
    }

    public function editExpressFee()
    {
        $result = $this->expressFeeService->editExpressFee($this->request->all());
        return $this->returnResult($result);
    }

    public function deleteExpressFee($expressFeeId)
    {
        $result = $this->expressFeeService->deleteExpressFee($expressFeeId);
        return $this->returnResult($result);
    }

    public function getExpressFeeInfo($expressFeeId)
    {
        $result = $this->expressFeeService->getExpressFeeInfo($expressFeeId);
        return $this->returnResult($result);
    }
}
