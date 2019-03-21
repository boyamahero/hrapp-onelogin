<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (array_wrap($attributes) as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });
        
            return $this;
        });

        Builder::macro('whereIsBoss', function ($attributes) {
            $this->where(function (Builder $query) use ($attributes) {
                foreach (array_wrap($attributes) as $attribute) {
                    if ($attribute === 'priority') {
                        $query->orWhereNotIn($attribute,['','04','05','06']);
                    } elseif ($attribute === 'employee_group') {
                        $query->orWhere($attribute,'9');
                    }
                }
            });
        
            return $this;
        });

        Resource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
