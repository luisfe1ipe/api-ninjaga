<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class FilterProjects
{

  /**
   * Apply filters to projects.
   *
   * @param Builder $projects
   * @param Request $request
   * @return Builder
   */
  public static function filter(Builder $projects, Request $request): Builder
  {
    $relationships = ['genres', 'authors', 'artists'];

    foreach ($relationships as $relation) {
      if ($request->filled($relation)) {
        $ids = $request->input($relation);
        $projects = self::filterByRelation($projects, $relation, $ids);
      }
    }

    $attributes = ['status', 'published_at'];

    foreach ($attributes as $attribute) {
      if ($request->filled($attribute)) {
        $value = $request->input($attribute);
        $projects = self::filterByAttribute($projects, $attribute, $value);
      }
    }

    return $projects;
  }

  /**
   * Apply filtering for relationships.
   *
   * @param Builder $projects
   * @param string $relation
   * @param array $ids
   * @return Builder
   */
  private static function filterByRelation(Builder $projects, string $relation, array $ids): Builder
  {
    return $projects->whereHas($relation, function (Builder $query) use ($ids, $relation) {
      $query->whereIn("{$relation}.id", $ids);
    });
  }

  /**
   * Apply filtering for direct attributes.
   *
   * @param Builder $projects
   * @param string $attribute
   * @param mixed $value
   * @return Builder
   */
  private static function filterByAttribute(Builder $projects, string $attribute, $value): Builder
  {
    return $projects->where($attribute, $value);
  }

}
