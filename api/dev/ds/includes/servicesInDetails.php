<?php
// Get all Categories
        $sqlAllCategories= "SELECT cat_id,cat_name FROM category";
        $runAllCategoriesQuery = $dbcon->prepare($sqlAllCategories);
        $runAllCategoriesQuery->execute();
        $allCategories = $runAllCategoriesQuery->fetchAll(PDO::FETCH_ASSOC);

// Get all Sub-Categories
        $sqlAllSubCategories= "SELECT subcat_id,subcat_name FROM subcategory";
        $runAllSubCategoriesQuery = $dbcon->prepare($sqlAllSubCategories);
        $runAllSubCategoriesQuery->execute();
        $allSubCategories = $runAllSubCategoriesQuery->fetchAll(PDO::FETCH_ASSOC);
        
// Get all Srvices
        $sqlAllServices= "SELECT DISTINCT srvice FROM services ORDER BY srvice ASC;";
        $runAllServicesQuery = $dbcon->prepare($sqlAllServices);
        $runAllServicesQuery->execute();
        $allServices = $runAllServicesQuery->fetchAll(PDO::FETCH_ASSOC);

// Get all at once
        $sqlDetailsAtOnce= "SELECT srv_sl, srvice, srvQty, srvPrice, srvStatus,cat_name, cat_id, subcat_name,subcat_id FROM services,category,subcategory WHERE subcategory.subcat_id = services.srvSubCategory AND category.cat_id = services.srvCategory ORDER BY srvice ASC;";
        $runDetailsAtOnceQuery = $dbcon->prepare($sqlDetailsAtOnce);
        $runDetailsAtOnceQuery->execute();
        $allServicesDeails = $runDetailsAtOnceQuery->fetchAll(PDO::FETCH_ASSOC);
        $row_count = $runDetailsAtOnceQuery->rowCount();

// Get Single Service Details
        // $sqlDetailsSingle= "SELECT * FROM services WHERE srv_sl = '$srvID' LIMIT 1;";
        // $runDetailsSingleQuery = $dbcon->prepare($sqlDetailsSingle);
        // $runDetailsSingleQuery->execute();
        // $singleServiceDeails = $runDetailsSingleQuery->fetchAll(PDO::FETCH_ASSOC);
        // $row_count = $runDetailsSingleQuery->rowCount();
?>