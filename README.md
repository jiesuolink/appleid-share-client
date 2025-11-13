# Apple ID Share Client - Laravel 包

一个用于集成 Apple ID 分享 API 的 Laravel Composer 包，让用户可以轻松在自己的 Laravel 项目中展示 Apple ID 信息。

## 功能特性

- ✅ 一键安装，自动注册路由和视图
- ✅ 调用主站 API 获取 Apple ID 信息
- ✅ 美观的 Bootstrap 界面
- ✅ 一键复制邮箱和密码
- ✅ 密码显示/隐藏切换
- ✅ 账号状态展示
- ✅ 过期时间检测
- ✅ 临时二维码生成
- ✅ 完整的错误处理
- ✅ 自动页面刷新

## 环境要求

- PHP >= 7.4
- Laravel >= 8.0

## 安装

### 1. 通过 Composer 安装

```bash
composer require jiesuolink/appleid-share-client
```

### 2. 发布配置文件（可选）

```bash
php artisan vendor:publish --tag=appleid-config
```

这将在 `config/appleid.php` 创建配置文件。

### 3. 发布视图文件（可选）

如果需要自定义视图：

```bash
php artisan vendor:publish --tag=appleid-views
```

视图文件将发布到 `resources/views/vendor/appleid-share/`

### 4. 配置环境变量

在 `.env` 文件中添加：

```env
APPLEID_API_URL=https://u.fast6.xyz/api/v2
APPLEID_TOKEN=your_token_here
APPLEID_TIMEOUT=10
```

**重要**：将 `your_token_here` 替换为您从 [https://www.jiesuo.link](https://www.jiesuo.link) 获取的真实 token。

## 使用方法

### 1. 访问分享页面

安装完成后，访问：

```
http://your-domain.com/share/appleid
```

### 2. 在代码中使用

如果需要在自己的控制器中调用：

```php
use AppleIdShare\ShareController;

// 在路由中
Route::get('/my-custom-route', [ShareController::class, 'showAppleId']);
```

## 配置说明

配置文件 `config/appleid.php`：

```php
return [
    // API 基础地址
    'api_url' => env('APPLEID_API_URL', 'https://u.fast6.xyz/api/v2'),

    // 访问令牌
    'token' => env('APPLEID_TOKEN', ''),

    // HTTP 超时设置（秒）
    'timeout' => env('APPLEID_TIMEOUT', 10),

    // 连接超时设置（秒）
    'connect_timeout' => env('APPLEID_CONNECT_TIMEOUT', 5),
];
```

### 配置项说明

| 配置项 | 环境变量 | 默认值 | 说明 |
|--------|---------|--------|------|
| `api_url` | `APPLEID_API_URL` | `https://u.fast6.xyz/api/v2` | 主站 API 地址 |
| `token` | `APPLEID_TOKEN` | - | 访问令牌（必填） |
| `timeout` | `APPLEID_TIMEOUT` | `10` | HTTP 请求超时时间（秒） |
| `connect_timeout` | `APPLEID_CONNECT_TIMEOUT` | `5` | 连接超时时间（秒） |

## API 响应示例

调用的主站 API 端点：

```
GET {api_url}/share/appleid/{token}
```

成功响应：

```json
{
  "success": true,
  "data": {
    "email": "example@hotmail.com",
    "password": "Dd1ab606a",
    "country": "美國",
    "status": 1,
    "interval": 10,
    "remark": "",
    "expired_at": "2026-02-01 22:38:02",
    "updated_at": "2025-11-11 17:10:05",
    "last_check": "2025-11-11 17:10:05",
    "token": "a3710b91a89a2b467434f5e7910b0f45",
    "temp_uri": null
  },
  "timestamp": 1762852741
}
```

## 错误处理

系统会自动处理以下错误：

| HTTP 状态码 | 错误信息 | 说明 |
|------------|---------|------|
| 400 | Token 无效 | 请检查配置的 token 是否正确 |
| 403 | IP 未授权访问 | 请联系管理员添加服务器 IP 到白名单 |
| 404 | 账号不存在 | Token 对应的账号不存在 |
| 其他 | API 请求失败 | 网络或服务器错误 |

所有错误都会记录到 Laravel 日志：

```bash
tail -f storage/logs/laravel.log
```

## 自定义视图

发布视图文件后，您可以完全自定义页面样式：

```bash
php artisan vendor:publish --tag=appleid-views
```

编辑文件：

```
resources/views/vendor/appleid-share/appleid.blade.php
```

## 页面功能

### 账号状态展示

- ✅ **正常**：绿色徽章，账号可用
- ⏳ **检测中**：蓝色徽章，正在检测账号状态
- ❌ **异常**：红色徽章，账号不可用

### 一键复制

点击"复制"按钮即可将邮箱或密码复制到剪贴板。

### 密码显示/隐藏

点击"显示"/"隐藏"按钮切换密码可见性。

### 自动刷新

页面每 180 秒（3 分钟）自动刷新一次，确保显示最新状态。

### 临时二维码

如果账号配置了临时访问功能，将自动生成二维码供手机扫描。

## 故障排除

### 问题：显示 "Token 无效"

**解决方法**：
1. 检查 `.env` 文件中的 `APPLEID_TOKEN` 配置
2. 确认 token 是否正确
3. 清除配置缓存：`php artisan config:clear`

### 问题：显示 "IP 未授权访问"

**解决方法**：
1. 联系管理员将您的服务器 IP 添加到白名单
2. 确认 IP 白名单配置是否生效

### 问题：页面 404 错误

**解决方法**：
1. 确认包已正确安装：`composer show | grep appleid`
2. 清除路由缓存：`php artisan route:clear`
3. 检查路由列表：`php artisan route:list | grep appleid`

### 问题：视图找不到

**解决方法**：
1. 清除视图缓存：`php artisan view:clear`
2. 确认 ServiceProvider 已注册：检查 `config/app.php` 或 `bootstrap/providers.php`

### 问题：网络超时

**解决方法**：
1. 增加超时时间：修改 `.env` 中的 `APPLEID_TIMEOUT`
2. 检查网络连接：`ping u.fast6.xyz`
3. 检查防火墙设置

## 目录结构

```
jiesuolink/appleid-share-client/
├── src/
│   ├── ShareController.php              # 控制器
│   └── AppleIdShareServiceProvider.php  # 服务提供者
├── config/
│   └── appleid.php                      # 配置文件
├── resources/
│   └── views/
│       └── appleid.blade.php            # 视图文件
├── tests/                               # 测试文件
├── composer.json                        # Composer 配置
├── .gitignore
└── README.md                            # 本文件
```

## 技术栈

- **Laravel**: 8.0+
- **PHP**: 7.4+
- **Guzzle**: 7.0+ (Laravel HTTP Client)
- **Bootstrap**: 4.6.2 (CDN)
- **Clipboard.js**: 2.0.11 (CDN)
- **QRCode.js**: 1.0.0 (CDN)

## 开发

### 运行测试

```bash
composer test
```

### 本地开发

1. Clone 仓库
2. 安装依赖：`composer install`
3. 创建 Laravel 测试项目并链接

```bash
cd /path/to/laravel/project
composer require "jiesuolink/appleid-share-client:@dev" --prefer-source
```

## 安全注意事项

1. **Token 保密**：不要将 `.env` 文件提交到版本控制
2. **IP 白名单**：确保服务器 IP 已添加到主站白名单
3. **HTTPS**：生产环境建议使用 HTTPS
4. **日志监控**：定期检查日志，监控异常访问

## 更新日志

### v1.0.0 (2025-11-12)

- 🎉 首次发布
- ✅ 基础 API 调用功能
- ✅ Laravel 自动注册
- ✅ 视图和配置发布

## 许可证

MIT License

## 支持

如有问题或建议，请提交 Issue 或 Pull Request。

## 致谢

感谢 Apple ID 管理系统提供的 API 支持。
