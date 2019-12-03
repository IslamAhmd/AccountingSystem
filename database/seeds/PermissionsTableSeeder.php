<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $clients = [
            'newCustomers',
            'viewCustomers',
            'viewHerCustomrs',
            'editDeleteCustomers',
            'editDeleteHerCustomrs',
            'viewAllActivities',
            'viewHerActive',
            'editSettingsCustomrs',
            'viewCustomersReports',
            'viewCustomersReportsSpecials',
        ];
        $clients_viewnames = [
            'اضافة عميل جديد',
            'عرض جميع العملاء',
            'عرض عملائه',
             'تعديل وحذف العملاء',
             'تعديل وحذف عملائه',
             'عرض جميع الانشطه',
             'عرض انشطته',
             'تعديل اعدادات العملاء',
             'عرض تقارير العملاء',
             'عرض تقارير العملاء الخاصه'
        ];
        foreach($clients as $i => $client){
            Permission::create([
                'type' => 'العملاء',
                'permission' => $client,
                'viewname' => $clients_viewnames[$i]
            ]);
        }



        $invoices = [
            'deleteEditPaymentsSpecial',
            'deleteEditAllPayments',
            'addInvoices',
            'editDeleteAllInvoices',
            'editDeleteAllInvoicesSpecial',
            'viewAllInvoices',
            'viewInvoicesSpecial',
            'addAllInvoices',
            'addAllInvoicesSpecial',
            'insertTaxReport',
            'invoiceAllProducts',
            'sellerChanged'
        ];
        $invoices_viewnames = [
            'حذف وتعديل المدفوعات الخاصة به',
            'حذف وتعديل جميع المدفوعات',
            'أضافة فواتير/عروض سعر',
            'تعديل وحذف كل فواتير/عروض سعر',
            'تعديل وحذف الفواتير الخاصه به/عروض سعر',
            'عرض كل فواتير/عروض سعر',
            'عرض الفواتير الخاصه به/عروض سعر',
            'اضافة عمليات دفع لكل الفواتير',
            'اضافة عمليات دفع الفواتير الخاصة به',
            'انشاء تقرير ضرائب',
            'فاتورة جميع المنتجات',
            'تغير البائع'
        ];
        foreach($invoices as $i => $invoice){
            Permission::create([
                'type' => 'الفواتير',
                'permission' => $invoice,
                'viewname' => $invoices_viewnames[$i]
            ]);
        }



        $settings = [
            'publicSettings',
            'TaxesSettings',
            'EditPaymentOptions',
            'viewSpecialReports',
        ];
        $settings_viewnames = [
            'تعديل الأعدادت العامه',
            'تعديل اعدادات الضرائب',
            'تعديل خيارات الدفع',
            'عرض تقارير خاصه'
        ];
        foreach($settings as $i => $setting){
            Permission::create([
                'type' => 'الاعدادات',
                'permission' => $setting,
                'viewname' => $settings_viewnames[$i]
            ]);
        }


        $products = [
            'addNewProduct',
            'viewAllProducts',
            'viewSpecialProducts',
            'editDeleteAllProducts',
            'editDeleteSpecialProducts',
            'addNewGroupPrices',
            'editDeleteNewGroupPrices',
            'editDeleteNewGroupPricesSpecial',
            'viewGroupPrices',
            'viewGroupPricesSpecial',
        ];
        $products_viewnames = [
            'اضافة منتج جديد',
            'عرض كل المنتجات',
            'عرض المنتجات الخاصة',
            'تعديل وحذف كل المنتجات',
            'تعديل وحذف المنتجات الخاصة',
            'اضافة مجموعة سعر جديده',
            'تعديل وحذف جميع مجموعة الأسعار',
            'تعديل وحذف جميع مجموعة الأسعار الخاصه به',
            'عرض جميع اسعار المجموعات',
            'عرض مجموعات الأسعار الخاصه به'
        ];
        foreach($products as $i => $product){
            Permission::create([
                'type' => 'المنتجات',
                'permission' => $product,
                'viewname' => $products_viewnames[$i]
            ]);
        }



        $inventories = [
            'buyMinimumPrices',
            'viewStockMovement',
            'editSpecialProducts',
            'addStorePermission',
            'editStorePermission',
            'viewNewGroupPrices',
            'addNewOrderBuy',
            'editDeleteNewOrderBuy',
            'editDeleteNewOrderBuySpecial',
            'viewOrderBuySpecial',
            'viewOrderBuy',
            'addNewSuppliers',
            'viewSuppliersdAdded',
            'viewAllSuppliers',
            'editDeleteSuppliersSpecial',
            'editDeleteAllSuppliersl',
            'editNumberProductsInStore',
            'FollowUpInventory',
            'MoveInventory'
        ];
        $inventories_viewnames = [
            'السماح للشراء بأقل من السعر الأدنى للمنتج',
            'عرض سعر حركة المخزون',
            'تعديل سعر حركة المخزون',
            'اضافة اذن مخزني',
            'تعديل اذن مخزني',
            'عرض اذن مخزني',
            'اضافة امر الشراء جديد',
            'تعديل او حذف كل اوامر الشراء جديد',
            'تعديل او حذف كل اوامر الشراء الخاصة',
            'عرض اوامر الشراء الخاصة به',
            'عرض كل اوامر الشراء',
            'اضافة موردين جدد',
            'عرض الموردين الذبن انشائهم',
            'عرض كل الموردين',
            'تعديل وحذف الموردين الخاصين به',
            'تعديل وحذف كل الموردين',
            'تعديل عدد المنتجات بالمخزون',
            'متابعة المخزون',
            'نقل المخزون'
        ];
        foreach($inventories as $i => $inventory){
            Permission::create([
                'type' => 'ادارة المخزون',
                'permission' => $inventory,
                'viewname' => $inventories_viewnames[$i]
            ]);
        }



        $tasks = [
            'addNotes',
            'addNotesSpecial',
            'editDeleteNotes',
            'editDeleteNotesSpecial',
            'viewAllNotes',
            'addAllNotesSpecial',
            'addNewOrderBuy'
        ];
        $tasks_viewnames = [
            'اضافة ملاحظات/مرفقات/مواعيد لجميع العملاء',
            'اضافة ملاحظات/مرفقات/مواعيد العملائه المعينين',
            'تعديل وحذف الملاحظات/المرفقات/المواعيد لجميع العملاء',
            'تعديل وحذف ملاحظاته مرفقاته-ومواعيده الخاصة',
            'عرض جميع ملاحظات/مرفقات/مواعيد لجميع العملاء',
            'عرض كافة ملاحظاته مرفقاته-ومواعيده الخاصة',
            'تعيين العملاء الى الموظفين'
        ];
        foreach($tasks as $i => $task){
            Permission::create([
                'type' => 'متابعة العمل',
                'permission' => $task,
                'viewname' => $tasks_viewnames[$i]
            ]);
        }



        $employees = [
            'addNewEmpolyee',
            'editDeleteEmpolyee',
            'addingNewRole',
            'editRole'
        ];
        $employees_viewnames = [
            'اضافة موظف جديد',
            'تعديل وحذف موظف',
            'اضافة دور وظيغي جديد',
            'تعديل الدور الموظفي'
        ];
        foreach($employees as $i => $employee){
            Permission::create([
                'type' => 'الموظفين',
                'permission' => $employee,
                'viewname' => $employees_viewnames[$i]
            ]);
        }


        $finances = [
            'addExpenseRecord',
            'editDeleteExpenseRecord',
            'editDeleteExpenseRecordSpecial',
            'viewExpenseRecord',
            'viewExpenseRecordAdded',
            'modifyVirtualSafe',
            'viewOwnVaults',
            'addNewRevenue',
            'editDeleteAllRevenue',
            'editDeleteAllRevenueSpecial',
            'viewAllRevenuel',
            'viewAllRevenuelAdded',
            'addRevenueExpenseClassification'
        ];
        $finances_viewnames = [
            'اضافة سجل مصروفات',
            'تعديل وحذف كل مصروفات',
            'تعديل وحذف المصروفات الخاصة به',
            'مشاهدة كل المصروفات',
            'مشاهدة المصروفات التي انشأها',
            'تعديل الخزينه الأفتراضيه',
            'عرض خزائنه الخاصة',
            'اضافة ايراد جديد',
            'تعديل وحذف كل الايرادات',
            'تعديل وحذف كل الايراد الخاص به',
            'عرض كل الايرادات',
            'عرض الايرادات التي انشأها',
            'اضافة تصنيف ايرادات/مصروفات'
        ];
        foreach($finances as $i => $finance){
            Permission::create([
                'type' => 'الماليه',
                'permission' => $finance,
                'viewname' => $finances_viewnames[$i]
            ]);
        }



        $imports = [
            'viewAllimportOrders',
            'viewAllimportOrdersSpecial',
            'addFilledOrders',
            'editDeleteAllimportOrdersSpecial',
            'editDeleteAllimportOrders',
            'ImportOrderStatusEventOccurred'
        ];
        $imports_viewnames = [
            'عرض جميع أوامر الاستيراد',
            'عرض أوامر الاستيراد الخاصة به',
            'اضافة اوامر شغل',
            'تعديل وحذف أوامر الاستيراد الخاصة به',
            'تعديل وحذف جميع أوامر الاستيراد',
            'حدث حالة امر استيراد'
        ];
        foreach($imports as $i => $import){
            Permission::create([
                'type' => 'أوامر الاستيراد',
                'permission' => $import,
                'viewname' => $imports_viewnames[$i]
            ]);
        }


        $accounts = [
            'addNewAssets',
            'viewCostCenters',
            'manageCostCenters',
            'manageLockedPeriods',
            'viewLockedPeriods',
            'manageConstraintAccounts',
            'viewConstraint',
            'viewConstraintSpecial',
            'addEditDeleteConstraint',
            'addEditDeleteConstraintSpecial'
        ];
        $accounts_viewnames = [
            'اضافة اصول جديده',
            'عرض مراكز التكلفة',
            'ادر مراكز التكلفة',
            'ادارة الفترات المقفله',
            'عرض الفترات المقفله',
            'ادر حسابات القيود',
            'عرض جميع القيود',
            'عرض جميع القيود الخاصة',
            'اضافة/تعديل/مسح جميع القيود',
            'اضافة/تعديل/مسح جميع القيود الخاصة'
        ];
        foreach($accounts as $i => $account){
            Permission::create([
                'type' => 'الحسابات العامه & القيود اليوميه',
                'permission' => $account,
                'viewname' => $accounts_viewnames[$i]
            ]);
        }



    }
}
