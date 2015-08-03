<?php
/**
 * Created by PhpStorm.
 * User: mreza
 * Date: 7/26/15
 * Time: 1:40 PM
 */

namespace Module\Content\Controller;


use Chumper\Datatable\Facades\DatatableFacade as Datatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Module\Content\Model\Form;

class GenerateController extends \BaseController{
    protected $form;
    public function getHello()
    {
        return 3;
    }

    public function getContentform(){
        $datatable = Datatable::table()
            ->addColumn('id')
            ->addColumn('item name', 'item type', 'action')
            ->setUrl(URL::to('module/content/generate/table'))
            ->render();
        return View::make('content::generate.create')
            ->with(array_merge($this->getForm(),['table' => $datatable]));
    }

    public function postNode()
    {
        Form::truncate();
        $attribute = new Form;
        $attribute->item = json_encode(Input::all());
        $attribute->save();

        $attributes = Form::all();
        foreach ($attributes as $attr) {
            $result[] = json_decode($attr,true);
        }

        return Redirect::to('module/content/generate/contentform')
            ->with('attributes' , $result);
    }

    public function getForm()
    {
        $contentNameText =[
            'name' => 'contentName',
            'label' => 'Content Name',
            'value' => ''
        ];
        $attributeNameText = [
            'name' => 'attributeName',
            'label' => 'Attribute Name',
            'value' => ''
        ];

        $attributeTypeSelect = [
            'name'     => 'attributeType',
            'label'    => 'Attribute Type',
            'value'    => '',
            'options'  => [
                'text' => 'text',
                'textarea' => 'textarea',
                'select'   => 'select',
                'filechooser' => 'filechooser',
            ]
        ];

        $attributeValueTextarea = [
            'name' => 'attributeValue',
            'label' => 'Attribute Value',
            'value' => ''
        ];

        $attributeRulesTextarea = [
            'name'  => 'attributeRules',
            'label' => 'Attribute Rules',
            'value' => ''
        ];

        $form = [
            'contentNameText' => $contentNameText,
            'attributeNameText' => $attributeNameText,
            'attributeTypeSelect' => $attributeTypeSelect,
            'attributeValueTextarea' => $attributeValueTextarea,
            'attributeRulesTextarea' => $attributeRulesTextarea,
        ];

        return $this->form = $form;
    }

    public function getTable()
    {
        $query = DB::table('forms');
        return Datatable::query($query)
            ->showColumns('id')
            ->addColumn('item name',function($query){
                $value  = json_decode($query->item,true)['attributeName'];
                return $value;
            })
            ->addColumn('item type',function($query){
                $value  = json_decode($query->item,true)['attributeType'];
                return $value;
            })
            ->addColumn('actions',function($query){
                $buttons  = "<a href='product/$query->id/edit' class='btn btn-success'>Edit</a>";
                $buttons .=
                    "<form method='post' style=\"display: inline;\"action=\"product/$query->id\">
                    <input name=\"_method\" type=\"hidden\" value=\"DELETE\">".
                    '<input type="submit" value="Delete" class="btn btn-danger" onclick="var r = confirm(\'آیا از حذف مطمئن هستید؟\'); if(r == false){return false;}">'.
                    "</form>";
                return $buttons;
            })
            ->make();
    }
}