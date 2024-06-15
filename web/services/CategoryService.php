<?php

// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Category.php';
class CategoryService extends Service
{
    public static function GetAllCategories()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Category');
        $categories = [];

        while ($row = $stmt->fetch()) {
            $categories[] = new Category($row['categoryID'], $row['label']);
        }

        return $categories;
    }
    public static function GetCategoryById(int $categoryID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Category WHERE categoryID = ' . $categoryID);
        $row = $stmt->fetch();
        return new Category($row['categoryID'], $row['label']);
    }

    public static function getAllCategoriesAsArrayOfString()
    {
        $categories = self::GetAllCategories();
        $categoriesStrings = [];

        foreach ($categories as $category) {
            $categoriesStrings[] = $category->getLabel();
        }

        return $categoriesStrings;
    }
}
?>
