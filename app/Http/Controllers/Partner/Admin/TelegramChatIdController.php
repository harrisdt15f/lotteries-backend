<?php

namespace App\Http\Controllers\Partner\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use App\Models\Admin\TelegramChatId;

class TelegramChatIdController extends Controller
{
    public function index() {
        $c          = \Request::all();
        $pager      = \Request::get("pageIndex", 1);
        $pageSize   = \Request::get("pageSize", 20);
        $offset     = ($pager - 1) * $pageSize;

        $data = TelegramChatId::getList($c, $offset, $pageSize);

        $buttonConfig = [
            ['route' => "telegramChatIdAdd", 'params' => []]
        ];
        $buttons = AdminMenu::buildButtons($buttonConfig);

        return Help::adminView("admin/telegram/chat_id_list")
            ->with('data',          $data)
            ->with('buttons',       $buttons);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function add($id = 0) {
        if ($id) {
            $chatId   = TelegramChatId::find($id);
            if (!$chatId) {
                return Help::AdminErrorView("无效的ID", 2);
            }
        } else {
            $chatId = new TelegramChatId();
        }

        if (\Request::isMethod('post')) {
            $res = $chatId->saveItem();
            if(true !== $res) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson(__('telegram_chat.add.success'), 1, ['url' => route("telegramChatIdList")]);
        }

        $type   = TelegramChatId::$types;

        return Help::adminView("admin/telegram/add")->with([
            'chatId'    => $chatId,
            'type'      => $type
        ]);
    }

    /**
     * 修改状态
     * @param $id
     * @return mixed
     */
    public function status($id) {
        $item   = TelegramChatId::find($id);
        if (!$item) {
            return Help::returnJson(__('error.account.id.invalid'), 0);
        }

        $item->status = $item->status  == 1 ? 0 : 1;
        $item->save();

        return Help::returnJson(__('error.account.status.success'), 1);
    }

    public function _getButtons() {
        return [];
    }
}
