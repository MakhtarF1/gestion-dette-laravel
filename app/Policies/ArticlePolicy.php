<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can view the article.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\Article  $article
     * @return bool
     */
    public function view(User $authUser, Article $article)
    {
        // Admin and 'boutiquier' can view articles
        return in_array(trim($authUser->role->libelle), ['admin', 'boutiquier']);
    }

    /**
     * Determine if the given user can create articles.
     *
     * @param  \App\Models\User  $authUser
     * @return bool
     */
    public function create(User $authUser)
    {
        // Only admin can create articles
        return $authUser->role->libelle === 'admin';
    }

    /**
     * Determine if the given user can update the article.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\Article  $article
     * @return bool
     */
    public function update(User $authUser, Article $article)
    {
        // Admin and 'boutiquier' can update articles
        return in_array(trim($authUser->role->libelle), ['admin', 'boutiquier']);
    }

    /**
     * Determine if the given user can delete the article.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\Article  $article
     * @return bool
     */
    public function delete(User $authUser, Article $article)
    {
        // Only admin can delete articles
        return $authUser->role->libelle === 'admin';
    }
}
