<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShareController extends Controller
{
    /**
     * 显示 Apple ID 分享页面
     *
     * @return \Illuminate\View\View
     */
    public function showAppleId()
    {
        try {
            // 从配置获取 API 地址和 token
            $apiUrl = config('appleid.api_url');
            $token = config('appleid.token');
            $timeout = config('appleid.timeout', 10);

            if (empty($token)) {
                return view('share.appleid', [
                    'error' => true,
                    'message' => '未配置 APPLEID_TOKEN，请检查 .env 文件'
                ]);
            }

            // 调用主站 API
            $endpoint = "{$apiUrl}/share/appleid/{$token}";

            $response = Http::timeout($timeout)->get($endpoint);

            // 检查 HTTP 状态码
            if ($response->failed()) {
                $statusCode = $response->status();
                $errorData = $response->json();

                $errorMessage = match ($statusCode) {
                    400 => $errorData['message'] ?? 'Token 无效',
                    403 => $errorData['message'] ?? 'IP 未授权访问',
                    404 => $errorData['message'] ?? '账号不存在',
                    default => 'API 请求失败: ' . $statusCode
                };

                Log::error('Apple ID API Error', [
                    'status' => $statusCode,
                    'response' => $errorData
                ]);

                return view('share.appleid', [
                    'error' => true,
                    'message' => $errorMessage
                ]);
            }

            // 解析成功响应
            $data = $response->json();

            if (!isset($data['success']) || !$data['success']) {
                return view('share.appleid', [
                    'error' => true,
                    'message' => $data['message'] ?? 'API 返回失败'
                ]);
            }

            // 传递数据到视图
            return view('share.appleid', [
                'error' => false,
                'appleId' => $data['data'],
                'timestamp' => $data['timestamp'] ?? time()
            ]);

        } catch (\Exception $e) {
            Log::error('Apple ID Share Page Error', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('share.appleid', [
                'error' => true,
                'message' => '系统错误: ' . $e->getMessage()
            ]);
        }
    }
}
