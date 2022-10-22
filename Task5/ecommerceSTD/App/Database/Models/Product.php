<?php
namespace App\Database\Models;


class Product extends Model {
    private $id,$name_en,$name_ar,$price,$code,$quantity,$details_en,$details_ar,$status,
    $brand_id,$subcategory_id,$image,$created_at,$updated_at , $category_id , $recent_products_limit , $most_ordered_products_limit;
    const ACTIVE = 1;
    const NOTACTIVE = 0;

    public function get() 
    {
        $query = "SELECT * FROM products WHERE status= " . self::ACTIVE;
        $stm = $this->conn->prepare($query);
        $stm->execute();

        return $stm->get_result();
    }
    public function getById() 
    {
        $query = "SELECT * FROM products_details WHERE status= " . self::ACTIVE . " AND id= ?";
        $stm = $this->conn->prepare($query);

        $stm->bind_param("i" , $this->id);
        $stm->execute();

        return $stm->get_result();
    }

    public function getByCategory() 
    {
        $query = "SELECT * FROM products_details WHERE status= " . self::ACTIVE . " AND category_id=?";
        $stm = $this->conn->prepare($query);
        $stm->bind_param("i" , $this->category_id);
        $stm->execute();

        return $stm->get_result();
    }

    public function getBySubCategory() 
    {
        $query = "SELECT * FROM products_details WHERE status= " . self::ACTIVE . " AND subcategory_id=?";
        $stm = $this->conn->prepare($query);
        $stm->bind_param("i" , $this->subcategory_id);
        $stm->execute();

        return $stm->get_result();
    }

    public function getByBrandId() 
    {
        $query = "SELECT * FROM products_details WHERE status= " . self::ACTIVE . " AND brand_id= ?";
        $stm = $this->conn->prepare($query);

        $stm->bind_param("i" , $this->brand_id);
        $stm->execute();

        return $stm->get_result();
    }

    public function getLatestProducts($numberOfProductsRetrived){
        $query = "SELECT * FROM `products` GROUP BY created_at DESC LIMIT ?";
        $stm = $this->conn->prepare($query);

        $stm->bind_param("i" , $numberOfProductsRetrived);
        $stm->execute();

        return $stm->get_result();
    }

    public function mostOrderedProducts(){
        $query = "SELECT * FROM `most_ordered_products` LIMIT ?";
        $stm = $this->conn->prepare($query);

        $stm->bind_param("i" , $this->most_ordered_products_limit);
        $stm->execute();

        return $stm->get_result();
    }
    
    
 

    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name_en
     */ 
    public function getName_en()
    {
        return $this->name_en;
    }

    /**
     * Set the value of name_en
     *
     * @return  self
     */ 
    public function setName_en($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get the value of name_ar
     */ 
    public function getName_ar()
    {
        return $this->name_ar;
    }

    /**
     * Set the value of name_ar
     *
     * @return  self
     */ 
    public function setName_ar($name_ar)
    {
        $this->name_ar = $name_ar;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of details_en
     */ 
    public function getDetails_en()
    {
        return $this->details_en;
    }

    /**
     * Set the value of details_en
     *
     * @return  self
     */ 
    public function setDetails_en($details_en)
    {
        $this->details_en = $details_en;

        return $this;
    }

    /**
     * Get the value of details_ar
     */ 
    public function getDetails_ar()
    {
        return $this->details_ar;
    }

    /**
     * Set the value of details_ar
     *
     * @return  self
     */ 
    public function setDetails_ar($details_ar)
    {
        $this->details_ar = $details_ar;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of brand_id
     */ 
    public function getBrand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @return  self
     */ 
    public function setBrand_id($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Get the value of subcategory_id
     */ 
    public function getSubcategory_id()
    {
        return $this->subcategory_id;
    }

    /**
     * Set the value of subcategory_id
     *
     * @return  self
     */ 
    public function setSubcategory_id($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Set the value of recent_products_limit
     *
     * @return  self
     */ 

    /**
     * Get the value of most_ordered_products_limit
     */ 
    public function getMost_ordered_products_limit()
    {
        return $this->most_ordered_products_limit;
    }

    /**
     * Set the value of most_ordered_products_limit
     *
     * @return  self
     */ 
    public function setMost_ordered_products_limit($most_ordered_products_limit)
    {
        $this->most_ordered_products_limit = $most_ordered_products_limit;

        return $this;
    }

    /**
     * Get the value of recent_products_limit
     */ 
    public function getRecent_products_limit()
    {
        return $this->recent_products_limit;
    }

    /**
     * Set the value of recent_products_limit
     *
     * @return  self
     */ 
    public function setRecent_products_limit($recent_products_limit)
    {
        $this->recent_products_limit = $recent_products_limit;

        return $this;
    }
}