<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\OrganizationStructure;
use App\AppMenu;
use function GuzzleHttp\json_encode;

class OrgTree {
    
    static $html;
    public static function orgData($parentCode)
    {
        $parent = OrganizationStructure::where("parent_code", $parentCode)->get();       
        self::$html.= "<ul>"; 
        foreach($parent as $row)
        {   
            $i = 0;
            if ($i == 0) 
            {
               
            }
            
            self::$html.= "<li title='".$row->code."'"; 
                $selfParent = OrganizationStructure::where("parent_code", $row->code)->get();
                if(count($selfParent) > 0 ) 
                {
                    self::$html.= " class='folder expanded'";
                }
            self::$html.=">".$row->name;
            self::orgData($row->code);
            self::$html.= "</li>";
            
            $i++;
            if ($i > 0) 
            {
                
            }  
        }
        self::$html.= "</ul>";
        return self::$html;              
    }

    static $html2;
    public static function orgDataChartToDisplay($parentCode)
    {
        $parent = OrganizationStructure::where("parent_code", $parentCode)->get();       
        self::$html2.= "<ul>"; 
        foreach($parent as $row)
        {   
            $i = 0;
            if ($i == 0) 
            {
               
            }
            
            self::$html2.= "<li title='".$row->code."'"; 
                $selfParent = OrganizationStructure::where("parent_code", $row->code)->get();
                if(count($selfParent) > 0 ) 
                {
                    self::$html2.= " class='folder expanded'";
                }
            self::$html2.=">".$row->name."~".$row->is_profitcenter;
            self::orgDataChartToDisplay($row->code);
            self::$html2.= "</li>";
            
            $i++;
            if ($i > 0) 
            {
                
            }  
        }
        self::$html2.= "</ul>";
        return self::$html2;              
    }

    static $ul_data;
    public static function orgDataChart($parentCode)
    {
        $parent = OrganizationStructure::where("parent_code", $parentCode)->get();       
        
        foreach($parent as $row)
        {   
            $i = 0;
            if ($i == 0) 
            {
                self::$ul_data.= "<ul>";   
            }
            
            self::$ul_data.= "<li title='".$row->name."'"; 
                $selfParent = OrganizationStructure::where("parent_code", $row->code)->get();
                if(count($selfParent) > 0 ) 
                {
                    self::$ul_data.= " class='folder expanded'";
                }
            self::$ul_data.=">".$row->name;
            self::orgDataChart($row->code);
            self::$ul_data.= "</li>";
            
            $i++;
            if ($i > 0) 
            {
                self::$ul_data.= "</ul>";
            }  
        }
        
        return self::$ul_data;              
    }

    static $menu_struct;
    public static function menuStruct($parentCode, $moduleId)
    {
        $parent = AppMenu::where("parent_id", $parentCode)->where("module_id", $moduleId)->where("status", 1)->get();       
        self::$menu_struct.= "<ul>"; 
        foreach($parent as $row)
        {   
            $i = 0;
            if ($i == 0) 
            {
               
            }
            
            self::$menu_struct.= "<li title='".$row->menu_id."'"; 
                $selfParent = AppMenu::where("parent_id", $row->menu_id)->where("module_id", $moduleId)->get();
                if(count($selfParent) > 0 ) 
                {
                    self::$menu_struct.= " class='folder expanded'";
                }
            self::$menu_struct.=">".$row->menu_title;
            self::menuStruct($row->menu_id, $moduleId);
            self::$menu_struct.= "</li>";
            
            $i++;
            if ($i > 0) 
            {
                
            }  
        }
        self::$menu_struct.= "</ul>";
        return self::$menu_struct;              
    }

    static $menu_priviledge2;
    static $number = 0;
    public static function menuPriviledge2($parentCode, $moduleId, $groupId)
    {
        $sqlStmt = "SELECT b.`access_type`, a.* FROM `mst_menu` a
                    LEFT JOIN `mst_group_access` b ON b.`module_id`=a.`module_id` AND b.`menu_id`=a.`menu_id`  AND b.`group_id`='".$groupId."'
                    WHERE a.`module_id`='".$moduleId."' AND a.`parent_id`='".$parentCode."' AND a.`status`='1'
                    ORDER BY a.`module_id`, a.`parent_id`, a.`order_number` ASC";
        $parent = DB::select(DB::raw($sqlStmt));   
        if(count($parent) > 0 ) {
        self::$menu_priviledge2.= "[";
        } 
        foreach($parent as $row)
        {   
            self::$number++;
            $i = 0;
            self::$menu_priviledge2.= "{ \"title\":\"".$row->menu_title."\", \"key\":\"".self::$number."#".$row->menu_id."#".$row->access_type."\", \"expanded\":true, "; 

                $sqlStmt = "SELECT b.`access_type`, a.* FROM `mst_menu` a
                            LEFT JOIN `mst_group_access` b ON b.`module_id`=a.`module_id` AND b.`menu_id`=a.`menu_id` AND b.`group_id`='".$groupId."'
                            WHERE a.`module_id`='".$moduleId."' AND a.`parent_id`='".$row->menu_id."' AND a.`status`='1'
                            ORDER BY a.`module_id`, a.`parent_id`, a.`order_number` ASC";
                $selfParent = DB::select(DB::raw($sqlStmt)); 
              
                if(count($selfParent) > 0 ) 
                {
                    self::$menu_priviledge2.= "\"folder\": true, \"children\":";
                }
                else{
                    self::$menu_priviledge2.= "\"folder\": false ";
                }
            self::$menu_priviledge2.="";
            self::menuPriviledge2($row->menu_id, $moduleId, $groupId);
            self::$menu_priviledge2.= "}, ";  
                      
            $i++;
        }
        if(count($parent) > 0 ) {
            self::$menu_priviledge2.= "]";
        } 
        
        return self::$menu_priviledge2;              
    }


    static $menu_bygroup;
    static $count = 0;
    public static function menuAccess($parentCode, $moduleId, $groupId)
    {
        self::$count++;
        $sqlStmt = "SELECT b.`access_type`, a.* FROM `mst_menu` a
                    JOIN `mst_group_access` b ON b.`module_id`=a.`module_id` AND b.`menu_id`=a.`menu_id`
                    WHERE a.`module_id`='".$moduleId."' AND a.`parent_id`='".$parentCode."' AND b.`group_id`='".$groupId."'
                    AND a.`status`='1'
                    ORDER BY a.`module_id`, a.`parent_id`, a.`order_number` ASC";
                    
        $parent = DB::select(DB::raw($sqlStmt)); 
        
        if(count($parent) > 0) {
            if($parentCode>0) {
                self::$menu_bygroup.= "<ul class='sidebar-submenu' id='headermenu_".$parentCode."'>";          
            }
        }        

        foreach($parent as $row)
        {   
            $i = 0;
            if ($i == 0) 
            {
                self::$menu_bygroup.= "<li class='drop' id='menu_".$row->menu_id."'>"; 
            }
            
            self::$menu_bygroup.= "<a href='".url('/').$row->menu_link."'><i class='fa ".$row->fa_icon."'></i> <span>".$row->menu_title."</span>";
            
                $sqlStmt = "SELECT b.`access_type`, a.* FROM `mst_menu` a
                JOIN `mst_group_access` b ON b.`module_id`=a.`module_id` AND b.`menu_id`=a.`menu_id`
                WHERE a.`module_id`='".$moduleId."' AND a.`parent_id`='".$row->menu_id."' AND b.`group_id`='".$groupId."'
                AND a.`status`='1'
                ORDER BY a.`module_id`, a.`parent_id`, a.`order_number` ASC";
                
                $selfParent = DB::select(DB::raw($sqlStmt)); 
              
                if(count($selfParent) > 0 ) 
                {
                    self::$menu_bygroup.= " <i class='fa fa-angle-left pull-right'></i></a>";
                }
                else{
                    self::$menu_bygroup.= " </a>";  
                }
            self::menuAccess($row->menu_id, $moduleId, $groupId);
                       
            $i++;

            if ($i == 0) 
            {
                self::$menu_bygroup.= "</li>";  
            }  
        }
        if(count($parent) > 0) {
            if($parentCode>0) {
                self::$menu_bygroup.= "</ul>";      
            }
        }
        return self::$menu_bygroup;              
    }
}