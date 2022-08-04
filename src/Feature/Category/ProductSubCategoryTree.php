<?php

namespace App\Feature\Category;

use App\Twig\SluggExtension;

/**
 * Prepare list fo categories and subcategories
 */
class ProductSubCategoryTree extends AbstractCategory
{
    public $ul='<ul>';
    public $ulC='</ul>';
    public $li='<li>';
    public $liC='</li>';

    /**
     * Build nested list of ProductCategory with link only for subcategories
     */
    public function getCategoriesList(array $categoriesArray)
    {
        $this->slugg = new SluggExtension();

        $this->categoryList .=$this->ul;

            foreach($categoriesArray as $category) {

                //slugify Productcategory name for url
                $categoryName = $this->slugg->doSlugg($category['name']);

                $url = $this->urlGenerator->generate('app_product_list', [
                    'categoryname' =>$categoryName,
                    'id'=> $category['id']]);
                
                //generate link only for subcategories
                if($category['parent_id'] == null) {
                    $this->categoryList .= $this->li.$category['name'];
                } else {
                    $this->categoryList .= $this->li.'<a href="'.$url.'">'.$category['name'].'</a>';
                }

                if(!empty($category['children'])) {
                    $this->getCategoriesList($category['children']);
                }
                $this->categoryList .=$this->liC;
            }

        $this->categoryList .= $this->ulC;
        return $this->categoryList;
        
    }

}
