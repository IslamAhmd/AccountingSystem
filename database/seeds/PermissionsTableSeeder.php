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
        Permission::create([
            'type' => 'العملاء',
            'name' => [
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
            ],
            'viewname' => [
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
            ]
        ]);

        Permission::create([
            'type' => 'الفواتير',
            'name' => [
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
            ],
            'viewname' => [
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
            ]
        ]);

        Permission::create([
            'type' => 'الاعدادات',
            'name' => [
                'publicSettings',
                'TaxesSettings',
                'EditPaymentOptions',
                'viewSpecialReports',
            ],
            'viewname' => [
                'تعديل الأعدادت العامه',
                'تعديل اعدادات الضرائب',
                'تعديل خيارات الدفع',
                'عرض تقارير خاصه'
            ]
        ]);

        Permission::create([
            'type' => 'المنتجات',
            'name' => [
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
            ],
            'viewname' => [
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
            ]
        ]);

        Permission::create([
            'type' => 'ادارة المخزون',
            'name' => [
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
            ],
            'viewname' => [
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
            ]
        ]);

        Permission::create([
            'type' => 'متابعة العمل',
            'name' => [
                'addNotes',
                'addNotesSpecial',
                'editDeleteNotes',
                'editDeleteNotesSpecial',
                'viewAllNotes',
                'addAllNotesSpecial',
                'addNewOrderBuy'
            ],
            'viewname' => [
                'اضافة ملاحظات/مرفقات/مواعيد لجميع العملاء',
                'اضافة ملاحظات/مرفقات/مواعيد العملائه المعينين',
                'تعديل وحذف الملاحظات/المرفقات/المواعيد لجميع العملاء',
                'تعديل وحذف ملاحظاته مرفقاته-ومواعيده الخاصة',
                'عرض جميع ملاحظات/مرفقات/مواعيد لجميع العملاء',
                'عرض كافة ملاحظاته مرفقاته-ومواعيده الخاصة',
                'تعيين العملاء الى الموظفين'
            ]
        ]);


        Permission::create([
            'type' => 'الموظفين',
            'name' => [
                'addNewEmpolyee',
                'editDeleteEmpolyee',
                'addingNewRole',
                'editRole'
            ],
            'viewname' => [
                'اضافة موظف جديد',
                'تعديل وحذف موظف',
                'اضافة دور وظيغي جديد',
                'تعديل الدور الموظفي'
            ]
        ]);

        Permission::create([
            'type' => 'الماليه',
            'name' => [
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
            ],
            'viewname' => [
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
            ]
        ]);

        Permission::create([
            'type' => 'أوامر الاستيراد',
            'name' => [
                'viewAllimportOrders',
                'viewAllimportOrdersSpecial',
                'addFilledOrders',
                'editDeleteAllimportOrdersSpecial',
                'editDeleteAllimportOrders',
                'ImportOrderStatusEventOccurred'
            ],
            'viewname' => [
                'عرض جميع أوامر الاستيراد',
                'عرض أوامر الاستيراد الخاصة به',
                'اضافة اوامر شغل',
                'تعديل وحذف أوامر الاستيراد الخاصة به',
                'تعديل وحذف جميع أوامر الاستيراد',
                'حدث حالة امر استيراد'
            ]
        ]);

        Permission::create([
            'type' => 'الحسابات العامه & القيود اليوميه',
            'name' => [
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
            ],
            'viewname' => [
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
            ]
        ]);


    }
}
