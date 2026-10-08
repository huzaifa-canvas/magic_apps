@extends('layouts.admin')

@section('title', 'Feed Posts')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation /</span> Feed Posts</h4>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">All Feed Posts</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Author</th>
                        <th>Content</th>
                        <th>Privacy</th>
                        <th>Published</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        @php
                            $author = $post->user;
                            $authorName = $author
                                ? (trim(($author->first_name ?? '') . ' ' . ($author->last_name ?? '')) ?: $author->email)
                                : '—';
                            $privacyColor = [
                                'public' => 'success',
                                'friends' => 'info',
                                'only_me' => 'secondary',
                            ][$post->privacy] ?? 'secondary';
                        @endphp
                        <tr>
                            <td><span class="text-body-secondary">#{{ $post->id }}</span></td>
                            <td>{{ $authorName }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($post->content, 60) ?: '—' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $privacyColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $post->privacy)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $post->is_published ? 'success' : 'secondary' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($post->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($post->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.feed-posts.show', $post->id) }}"
                                    class="btn btn-sm btn-outline-secondary">View</a>
                                <form action="{{ route('admin.feed-posts.toggle-publish', $post->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $post->is_published ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                        {{ $post->is_published ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.feed-posts.destroy', $post->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-body-secondary py-5">No feed posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($posts->hasPages())
            <div class="card-footer">{{ $posts->links() }}</div>
        @endif
    </div>
@endsection
