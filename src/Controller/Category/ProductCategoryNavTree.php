<?php

namespace App\Controller\Category;

class ProductCategoryNavTree extends AbstractCategory
{
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
