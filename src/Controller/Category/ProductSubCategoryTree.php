<?php

namespace App\Controller\Category;

class ProductSubCategoryTree extends AbstractCategory
{
    public $ul='<ul>';
    public $ulC='</ul>';
    public $li='<li>';
    public $liC='</li>';

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

}
