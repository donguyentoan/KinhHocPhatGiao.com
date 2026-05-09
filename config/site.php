<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Liên kết ủng hộ qua Momo
    |--------------------------------------------------------------------------
    |
    | Trong .env: MOMO_DONATE_URL=https://me.momo.vn/...
    | Để trống: nút dẫn tới trang Liên hệ hỗ trợ.
    | DONATE_URL vẫn được đọc nếu MOMO_DONATE_URL chưa đặt (tương thích cũ).
    |
    */

    'momo_donate_url' => env('MOMO_DONATE_URL', env('DONATE_URL')),

];
