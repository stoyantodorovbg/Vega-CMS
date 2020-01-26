<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\MenuItem;
use App\DataMappers\MenuDataMapper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminMenuItemRequest;
use App\Repositories\Interfaces\DefaultJsonStructureRepositoryInterface;

class MenuItemsController extends Controller
{
    /**
     * Admin menu items menus page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Menu $menu, int $menuItem)
    {
        $defaultFilters = [
            'menu_id' => [
                'types' => [
                    'exact' => [
                        'value' => $menu->id
                    ]
                ]
            ],
            'parent_id' => [
                'types' => [
                    'exact' => [
                        'value' => $menuItem ? $menuItem->id : null
                    ]
                ]
            ]
        ];

        return view('admin.menu_items.index')->with([
            'defaultFilters' => json_encode($defaultFilters),
            'menuSlug' => $menu->getSlug()
        ]);
    }

    /**
     * Admin menu items show page
     *
     * @param MenuItem $menuItem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(MenuItem $menuItem)
    {
        return view('admin.menu_items.show', compact('menuItem'));
    }

    /**
     * Admin menu items create page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $defaultJsonStructureRepository = resolve(DefaultJsonStructureRepositoryInterface::class);
        $defaultJsonFieldsData = $defaultJsonStructureRepository->getJsonStructureFields(MenuItem::class)
            ->pluck('structure', 'field')->toArray();

        return view('admin.menu_items.create', compact('defaultJsonFieldsData'));
    }

    /**
     * Admin menu items store action
     *
     * @param AdminMenuItemRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(AdminMenuItemRequest $request)
    {
        $menuItem = MenuItem::create($request->validated());

        return redirect()->route('admin-menu-items.show', $menuItem->getSlug())
            ->with(compact('menuItem'));
    }

    /**
     * Admin menu items edit page
     *
     * @param MenuItem $menuItem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(MenuItem $menuItem)
    {
        $menuItem->loadAllChildItems($menuItem);

        return view('admin.menu_items.edit', compact('menuItem'));
    }

    /**
     * Admin menu items update action
     *
     * @param MenuItem $menuItem
     * @param AdminMenuItemRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(MenuItem $menuItem, AdminMenuItemRequest $request)
    {
        $mappedData = resolve(MenuDataMapper::class)->mapData($request->validated());

        $menuItem->update($mappedData);

        return redirect()->back()->with(compact('menuItem'));
    }
}
