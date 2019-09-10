<?php
// Get all Categories
        $sqlAllCategories= "SELECT * FROM category";
        $runAllCategoriesQuery = $dbcon->prepare($sqlAllCategories);
        $runAllCategoriesQuery->execute();
        $allCategories = $runAllCategoriesQuery->fetchAll(PDO::FETCH_ASSOC);

// Get all Sub-Categories
        $sqlAllSubCategories= "SELECT * FROM subcategory";
        $runAllSubCategoriesQuery = $dbcon->prepare($sqlAllSubCategories);
        $runAllSubCategoriesQuery->execute();
        $allSubCategories = $runAllSubCategoriesQuery->fetchAll(PDO::FETCH_ASSOC);
        
// Get all Srvices
        $sqlAllServices= "SELECT * FROM `service` ORDER BY `name` ASC;";
        $runAllServicesQuery = $dbcon->prepare($sqlAllServices);
        $runAllServicesQuery->execute();
        $allServices = $runAllServicesQuery->fetchAll(PDO::FETCH_ASSOC);

// Get all at once
        $sqlDetailsAtOnce= "SELECT 
                                service.id as srv_sl, 
                                service.name as srvice, 
                                category.name as cat_name, 
                                subcategory.name as subcat_name,
                                service.price as srvPrice, 
                                service.status as srvStatus
                                FROM
                                category
                                        INNER JOIN
                                subcategory ON subcategory.category_id = category.id
                                        INNER JOIN
                                `service` ON subcategory.id = service.subcategory_id
                                ORDER BY `service`.name ASC;";
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