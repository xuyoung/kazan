<?php
namespace App\KaZanApp\Product\Controllers;

use App\KaZanApp\Base\Controller;
use Illuminate\Http\Request;

/**
 * 产品 controller ，实现产品管理菜单的所有内容，以及所有和产品模块相关的功能实现
 * 这个类，用来：1、验证request；2、组织数据；3、调用service实现功能；[4、组织返回值]
 *
 * @author
 *
 * @since
 */
class ProductController extends Controller
{
    public function __construct(
        Request $request
    ) {
        parent::__construct();
        $this->productService     = app('App\KaZanApp\Product\Services\ProductService');
        $this->productTypeService = app('App\KaZanApp\Product\Services\ProductTypeService');
        $this->productRequest     = app('App\KaZanApp\Product\Requests\ProductRequest');
        $this->formFilter($request, $this->productRequest);
        $this->request = $request;
    }

    /**
     * 获取产品列表数据和数量
     *
     * @param {int} autoFixPage 起始页
     * @param {int} limit 每页显示数量
     * @param {json} order_by 排序
     * @param {int} page 页码
     * @param {json} search 查询条件
     *
     * @paramExample {string} 参数示例
     * {
     *  autoFixPage: 1
     *  limit: 10
     *  order_by: {"product_id":"desc"}
     *  page: 2
     *  search: {"product_name":['飘窗',"like"]}
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          "total": 69, // 产品数量
     *          "list": [ // 产品列表
     *              {
     *                  "product_id": "1", // 产品ID
     *                  "product_name": "飘窗", // 产品名称
     *                  "product_name_py": "piaochuang",
     *                  "product_name_zm": "pc",
     *              },
     *          ...
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function getProductListAndTotal()
    {
        $result = $this->productService->getProductListAndTotal($this->request->all());
        return $this->returnResult($result);
    }

    /**
     * 添加产品
     *
     * @param {string} product_name 产品名称
     *
     * @paramExample {string} 参数示例
     * {
     *  product_name: '飘窗'
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          product_id: 1, // 产品ID
     *          product_name: "飘窗",
     *          created_at: "2018-06-24 16:35:02",
     *          updated_at: "2018-06-24 16:35:02",
     *          product_name_py: "piaochuang",
     *          product_name_zm: "pc",
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function addProduct()
    {
        $result = $this->productService->addProduct($this->request->all());
        return $this->returnResult($result);
    }

    /**
     * 编辑产品
     *
     * @param {int} $productId 产品ID
     * @param {string} product_name 产品名称
     *
     * @paramExample {string} 参数示例
     * {
     *  product_id: 1,
     *  product_name: '飘窗1'
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": 1 // 更新成功
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function editProduct($productId)
    {
        $result = $this->productService->editProduct($this->request->all(), $productId);
        return $this->returnResult($result);
    }

    /**
     * 删除产品
     *
     * @param {string} $productId 产品ID
     *
     * @paramExample {string} 参数示例
     * api/product/product/1
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": 1
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function deleteProduct($productId)
    {
        $result = $this->productService->deleteProduct($productId);
        return $this->returnResult($result);
    }

    /**
     * 获取产品类别信息
     *
     * @param {int} $productId 产品ID
     *
     * @paramExample {string} 参数示例
     * api/product/product/1
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          product_id: 1, // 产品ID
     *          product_name: "飘窗",
     *          created_at: "2018-06-24 16:35:02",
     *          updated_at: "2018-06-24 16:35:02",
     *          product_name_py: "piaochuang",
     *          product_name_zm: "pc",
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function getProductInfo($productId)
    {
        $result = $this->productService->getProductInfo($productId);
        return $this->returnResult($result);
    }

    /**
     * 获取产品类别列表数据和数量
     *
     * @param {int} autoFixPage 起始页
     * @param {int} limit 每页显示数量
     * @param {json} order_by 排序
     * @param {int} page 页码
     * @param {json} search 查询条件
     *
     * @paramExample {string} 参数示例
     * {
     *  autoFixPage: 1
     *  limit: 10
     *  order_by: {"product_type_id":"desc"}
     *  page: 2
     *  search: {"product_type_name":['飘窗',"like"]}
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          "total": 69, // 产品类别数量
     *          "list": [ // 产品类别列表
     *              {
     *                  "product_type_id": "1", // 产品类别ID
     *                  "product_type_name": "飘窗", // 产品类别名称
     *                  "product_type_name_py": "piaochuang",
     *                  "product_type_name_zm": "pc",
     *              },
     *          ...
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function getProductTypeListAndTotal()
    {
        $result = $this->productTypeService->getProductTypeListAndTotal($this->request->all());
        return $this->returnResult($result);
    }

    /**
     * 添加产品类别
     *
     * @param {string} product_type_name 产品类别名称
     *
     * @paramExample {string} 参数示例
     * {
     *  product_type_name: '飘窗'
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          product_type_id: 1, // 产品类别ID
     *          product_type_name: "飘窗",
     *          created_at: "2018-06-24 16:35:02",
     *          updated_at: "2018-06-24 16:35:02",
     *          product_type_name_py: "piaochuang",
     *          product_type_name_zm: "pc",
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function addProductType()
    {
        $result = $this->productTypeService->addProductType($this->request->all());
        return $this->returnResult($result);
    }

    /**
     * 编辑产品类别
     *
     * @param {int} product_type_id 产品类别ID
     * @param {string} product_type_name 产品类别名称
     *
     * @paramExample {string} 参数示例
     * {
     *  product_type_id: 1,
     *  product_type_name: '飘窗1'
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": 1 // 更新成功
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function editProductType($typeId)
    {
        $result = $this->productTypeService->editProductType($this->request->all(), $typeId);
        return $this->returnResult($result);
    }

    /**
     * 删除产品类别
     *
     * @param {string} product_type_id 产品类别ID
     *
     * @paramExample {string} 参数示例
     * api/product/product-type/1
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": 1
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function deleteProductType($typeId)
    {
        $result = $this->productTypeService->deleteProductType($typeId);
        return $this->returnResult($result);
    }

    /**
     * 获取产品类别信息
     *
     * @param {int} $typeId 产品类别ID
     *
     * @paramExample {string} 参数示例
     * api/product/product-type/1
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          product_type_id: 1, // 产品类别ID
     *          product_type_name: "飘窗",
     *          created_at: "2018-06-24 16:35:02",
     *          updated_at: "2018-06-24 16:35:02",
     *          product_type_name_py: "piaochuang",
     *          product_type_name_zm: "pc",
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function getProductTypeInfo($typeId)
    {
        $result = $this->productTypeService->getProductTypeInfo($typeId);
        return $this->returnResult($result);
    }
}
