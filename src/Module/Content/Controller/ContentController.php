<?php
namespace Module\Content\Controller;

use Chumper\Datatable\Facades\DatatableFacade as Datatable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Module\Content\Model\Content;
use Module\Taxonomy\Model\Tag;
use Module\Taxonomy\Model\Taxonomy;
use Module\Taxonomy\Model\Category;

class ContentController extends \BaseController{
    protected $form;

    public function index()
    {
        $datatable = Datatable::table()
            ->addColumn('id', 'title', 'type')
            ->addColumn('actions')
            ->setUrl(URL::to('module/content/table'))
            ->render();
        return View::make('content::list')->with(['table' => $datatable, 'url' => "product/create"]);
    }

    public function getTable()
    {
        $query = DB::table('contents');
        return Datatable::query($query)
            ->showColumns('id', 'title', 'type')
            ->addColumn('actions',function($query){
                $buttons  = "<a href='product/$query->id/edit' class='btn btn-success'>Edit</a>";
                $buttons .=
                    "<form method='post' style=\"display: inline;\"action=\"product/$query->id\">
                    <input name=\"_method\" type=\"hidden\" value=\"DELETE\">".
                    '<input type="submit" value="Delete" class="btn btn-danger" onclick="var r = confirm(\'آیا از حذف مطمئن هستید؟\'); if(r == false){return false;}">'.
                    "</form>";
                return $buttons;
            })
            ->searchColumns(['title', 'type'])
            ->orderColumns('id','title')
            ->make();
    }

    public function create()
    {
        return View::make('content::create')
            ->with($this->getForm());
    }

    public function edit($id)
    {
        $form = $this->getForm();
        $content = Content::findOrFail($id);
        foreach ($form as $name => $element) {
            if($element['name'] == 'category'){
                foreach ($content->categories as $category) {
                    $form[$name]['value'][] =$category->id;
                }
                continue;
            }
            if($element['name'] == 'status'){
                if($content->{$element['name']} == 'active'){
                    $form[$name]['checked'] = true;
                }
                continue;
            }
            if($element['name'] == 'tag'){
                foreach ($content->tags as $tag) {
                    $form[$name]['value'][] =$tag->id;
                }
                continue;
            }
            $form[$name]['value'] = $content->{$element['name']};
        }
        return View::make('content::edit')
            ->with(array_merge($form, ['id' => $id]));
    }

    public function update($id)
    {
        $tags = [];
        $categories =[];
        $data = Input::all();
        $content = Content::find($id);
        foreach ($data as $key => $value) {
            if($key == 'category'){
                $categories = $value;
                continue;
            }
            if($key == '_method'){
                continue;
            }
            if($key == 'tag'){
                $tags = $value;
                continue;
            }
            $content->{$key} = $value;
        }
        if(!array_key_exists('status', $data)){
            $content->status = '';
        }
        $content->save();
        $content->categories()->detach();
        if($categories != []){
            $content->categories()->attach($categories);
        }
        $content->tags()->detach();
        if($tags != []){
            $content->tags()->attach($tags);
        }
        return Redirect::to('module/content/product');
    }

    public function destroy($id)
    {
        $content = Content::find($id);
        $content->delete();
        return Redirect::to('module/content/product');
    }

    public function show($id){
        return $id;
    }

    public function store()
    {
        $categories = [];
        $tags = [];
        $inputs = Input::all();
        $newContent = new Content;
        foreach ($inputs as $content => $value) {
            if($content == 'category'){
                $categories = $value;
                continue;
            }
            if($content == 'tag'){
                $tags = $value;
                continue;
            }
            $newContent->{$content} = $value;
        }

        $newContent->save();
        if($categories != []){
            $newContent->categories()->attach($categories);
        }
        if($tags != []){
            $newContent->tags()->attach($tags);
        }
        return Redirect::to('module/content/product');
    }

    public function getForm()
    {
        if(isset($this->form)){
            return $this->form;
        }
        $text = [
            'name'  => 'title',
            'label' => 'عنوان محتوا',
            'value' => '',
        ];
        $typeSelect = [
            'name'  => 'type',
            'label' => 'نوع محتوا',
            'value' => '',
            'options' => [
                'محصول' => 'محصول',
                'خبر'  => 'خبر',
            ]
        ];
        $textarea = [
            'name'  => 'description',
            'label' => 'توضیحات',
            'value' => ''
        ];
        $checkbox = [
            'label' => 'انتشار',
            'name'  => 'status',
            'value' => 'active',
            'checked' => false
        ];
        $file = [
            'label' => 'ویدیو/عکس',
            'name'  => 'attachment',
            'value' => ''
        ];
        $categories = Taxonomy::find(Config::get('content::categoryId'))->categories;
        foreach ($categories as $category) {
            $result[$category->id] = $category->title;
        }

        $categorySelect = [
            'isMulti' => true,
            'name'    => 'category',
            'label'   => 'دسته',
            'value'   => '',
            'options' => $result
        ];

        $tags = Tag::all();
        foreach ($tags as $tag) {
            $tagResult[$tag->id] = $tag->title;
        }


        $tagSelect2 = [
            'isMulti' => true,
            'name'    => 'tag',
            'label'   => 'برچسب محتوا',
            'value'   => '',
            'options' => $tagResult,
        ];

        $form = [
            'text'     => $text,
            'typeSelect'   => $typeSelect,
            'textarea' => $textarea,
            'checkbox' => $checkbox,
            'file'     => $file,
            'tagSelect2' => $tagSelect2,
            'categorySelect' => $categorySelect
        ];
        return $this->form = $form;
    }

}