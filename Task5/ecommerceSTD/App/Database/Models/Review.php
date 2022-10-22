<?php
namespace App\Database\Models;

use App\Database\Models\Model;


class Review extends Model{
    private $product_id,$user_id,$rate,$created_at,$updated_at , $comment;
    

    public function getReviewsByProductId() 
    {
        $query = "SELECT * FROM reviews_details WHERE product_id=? AND user_id =?" ;
        $stm=$this->conn->prepare($query);
        $stm->bind_param("ii" , $this->product_id , $this->user_id);
        $stm->execute();
        return $stm->get_result();
    }

    public function getReviewPerUserAndProduct() 
    {
        $query = "SELECT * FROM products_orders_users WHERE product_id=? AND user_id =?" ;
        $stm=$this->conn->prepare($query);
        $stm->bind_param("ii" , $this->product_id , $this->user_id);
        $stm->execute();
        return $stm->get_result();
    }

    public function updateReview() :bool
    {
        $query = "UPDATE reviews SET rate = ? , comment =? WHERE product_id = ? AND user_id = ?";
        $stm = $this->conn->prepare($query); // check query syntax
        $stm->bind_param('isii',$this->rate,$this->comment , $this->product_id , $this->user_id); // pass paramerters 
        $stm->execute();
        return $stm->get_result();
    }

    

    /**
     * Get the value of product_id
     */ 
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of rate
     */ 
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @return  self
     */ 
    public function setRate($rate)
    {
        $this->rate = $rate;

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
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */ 
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }
}