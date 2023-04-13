<?php

return [
    'response_format' => [
        'status' => '',
        'message' => '',
        'data' => ''
    ],
    /**
     * APIのレスポンスステータスコード
     */
    'result_status' => [
        'success' => 200, // 正常に成功にした場合
        'created' => 201, // レコードを新規作成した場合
        'no_content' => 204, // 正常なリクエストが来たが、レスポンスの中身が無かった場合
        'unauthorized' => 401, // 未認証
        'method_not_allowed' => 405, // ルーティングが無い
        'conflict' => 409, // 作成・パッチ・削除しようとしたリソースが既にある、または、更新しようとしたリソースがロック中（楽観・悲観どちらでも）の場合
        'bad_request' => 422, // 引数が足りない・バリデーションに引っかかった場合など
        'server_error' => 500, // サーバ内部にエラーが発生した場合。予期しないサーバー処理のエラー。
        'service_unavailable' => 503, // 一時的にサービス提供ができない場合。（メンテナンス等）
    ],
    /**
     * ステータスコードに基づくエラーメッセージ
     */
    'messages' => [
        200 => 'success',
        201 => 'success',
        204 => 'There was no data to return as a response.',
        401 => 'Unauthorized error.',
        405 => 'Method not allowed.',
        409 => 'Data Conflict error.',
        422 => 'Validation error. There is a problem with the request params.',
        500 => 'Server error',
        503 => 'Server Unavailable. Contact your server administrator.',
    ],
];