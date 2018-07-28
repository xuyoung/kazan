<?php
namespace App\KaZanApp\Formula\Controllers;

use Illuminate\Http\Request;
use App\KaZanApp\Base\Controller;
use Illuminate\Support\Facades\DB;

/**
 * 公式 controller ，实现公式管理菜单的所有内容，以及所有和公式模块相关的功能实现
 * 这个类，用来：1、验证request；2、组织数据；3、调用service实现功能；[4、组织返回值]
 *
 * @author
 *
 * @since
 */
class FormulaController extends Controller
{
    public function __construct(
        Request $request
    ) {
        parent::__construct();
        $this->formulaService = app('App\KaZanApp\Formula\Services\FormulaService');
        $this->formulaRequest = app('App\KaZanApp\Formula\Requests\FormulaRequest');
        $this->formFilter($request, $this->formulaRequest);
        $this->request = $request;
    }

    public function getFormulaListAndTotal()
    {
        $result = $this->formulaService->getFormulaListAndTotal($this->request->all());
        return $this->returnResult($result);
    }

    public function addFormula()
    {
        $result = $this->formulaService->addFormula($this->request->all());
        return $this->returnResult($result);
    }

    public function editFormula($formulaId)
    {
        $result = $this->formulaService->editFormula($this->request->all(), $formulaId);
        return $this->returnResult($result);
    }

    public function deleteFormula($formulaId)
    {
        $result = $this->formulaService->deleteFormula($formulaId);
        return $this->returnResult($result);
    }

    public function getFormulaInfo($formulaId)
    {
        $result = $this->formulaService->getFormulaInfo($formulaId);
        return $this->returnResult($result);
    }
}
