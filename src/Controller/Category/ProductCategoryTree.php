<?php

namespace App\Controller\Category;

class ProductCategoryTree extends AbstractCategory
{
    public $ul='<ul>';
    public $ulC='</ul>';
    public $li='<li>';
    public $liC='</li>';


    public function getCategoryListAndParent(int $id): string
    {
        $parentData = $this->getMainParent($id);
        $this->mainParentName = $parentData['name'];
        $this->mainParentId = $parentData['id'];
        $key = array_search($id, array_column($this->allCategories,
        'id'));

        $this->currentCategoryName = $this->allCategories[$key]['name'];

        //array for generating nested html list
        $categoriesArray = $this->buildTree($parentData['id']);
        return $this->getCategoriesList($categoriesArray);

    }

    public function getCategoriesList(array $categoriesArray)
    {

        $this->categoryList .= $this->ul;
        foreach($categoriesArray as $category) {
            $categoryName = $category['name'];
            $url = $this->urlGenerator->generate('app_product_list', [
                'categoryname' =>$categoryName,
                'id'=> $category['id']]);
            $this->categoryList .= $this->li.'<a href="'.$url.'">'.$categoryName.'</a>';

            if(!empty($category['children'])) {
                $this->getCategoriesList($category['children']);
            }
            $this->categoryList .=$this->liC;
        }
        $this->categoryList .= $this->ulC;
        return $this->categoryList;
    }

    public function getMainParent(int $id): array 
    {
        $key = array_search($id, array_column($this->allCategories, 'id'));
        if($this->allCategories[$key]['parent_id'] !=null) {
            return $this->getMainParent($this->allCategories[$key]['parent_id']);
        } else {
            return [
            'id'=>$this->allCategories[$key]['id'],
            'name'=>$this->allCategories[$key]['name']];
        }
    }


}
