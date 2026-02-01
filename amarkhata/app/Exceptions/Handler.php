namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // বিস্তারিত এরর লগিং
            Log::error('এপ্লিকেশন এরর: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'ip' => request()->ip(),
                'user_id' => auth()->id() ?? 'অতিথি'
            ]);
        });
        
        // 403 Forbidden এরর বিশেষভাবে লগ করা
        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, $request) {
            Log::warning('403 Forbidden এরর:', [
                'url' => request()->fullUrl(),
                'user_id' => auth()->id() ?? 'অতিথি',
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            
            return response()->view('errors.403', [], 403);
        });
    }
} 