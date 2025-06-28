<?php

namespace App\Http\Controllers;

use App\Helpers\CommentHelper;
use App\Helpers\DeleteHelper;
use App\Helpers\RouteHelper;
use App\Models\Comment;
use App\Notifications\CommentReplyCreated;
use App\Notifications\UserCommentCreated;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('create comments');
        $request->validate([
            'text' => 'required|string|min:2',
            'parent_id' => 'nullable|exists:comments,id',
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
        ]);
        if ($request->parent_id) {
            $parent = Comment::where('id', $request->parent_id)->first();
            $request->commentable_type = $parent->commentable_type;
            $request->commentable_id = $parent->commentable_id;
        } else {
            $modelClass = $request->commentable_type;
            if (!\in_array($modelClass, CommentHelper::COMMENTABLE)) {
                abort(404);
            }
            $this->requireExistingId($modelClass, $request->commentable_id);
        }

        $comment = new Comment;
        $comment->text = $request->text;
        $comment->parent_id = $request->parent_id;
        $comment->commentable_type = $request->commentable_type;
        $comment->commentable_id = $request->commentable_id;
        $this->setUserId($comment);
        $comment->save();

        return redirect()->back()->with('success', __('comments.created_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        $this->requireOrAbort(CommentHelper::canEdit($comment));

        return view('pages.comments.edit', [
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->requireOrAbort(CommentHelper::canEdit($comment));
        $request->validate([
            'text' => 'required|string|min:2',
        ]);

        $comment->text = $request->text;
        $comment->save();

        $view = RouteHelper::SHOW[$comment->commentable_type];
        return redirect()->route($view, $comment->commentable_id)->with('success', __('comments.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->requireOrAbort(CommentHelper::canDelete($comment));

        DeleteHelper::deleteComment($comment);

        $view = RouteHelper::SHOW[$comment->commentable_type];
        return redirect()->route($view, $comment->commentable_id)->with('success', __('comments.deleted_successfully'));
    }
}
