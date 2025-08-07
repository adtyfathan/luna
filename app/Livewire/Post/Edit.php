<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\GambarPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    use WithFileUploads;

    public Post $post;
    public $konten = '';
    public $images = [];
    public $newImages = [];
    public $existingImages = [];
    public $imagesToDelete = [];

    protected $rules = [
        'konten' => 'required|string|max:5000',
        'newImages.*' => 'nullable|image|max:5120', // 5MB max per image
    ];

    protected $messages = [
        'konten.required' => 'Content is required.',
        'konten.max' => 'Content cannot exceed 5000 characters.',
        'newImages.*.image' => 'Each file must be an image.',
        'newImages.*.max' => 'Each image cannot exceed 5MB.',
    ];

    public function mount($postId)
    {
        $this->post = Post::find($postId);

        // Check if user owns this post
        if ($this->post->author_id !== Auth::id() || $this->post->author_type !== 'user') {
            abort(403, 'Unauthorized action.');
        }

        $this->konten = $this->post->konten;

        // Load existing images
        $this->existingImages = $this->post->gambarPost()->get();
        $this->images = [];
        $this->imagesToDelete = [];
    }

    public function updatedNewImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:5120',
        ]);

        // Add new images to existing images array
        if (!empty($this->newImages)) {
            foreach ($this->newImages as $newImage) {
                $totalImages = count($this->existingImages) + count($this->images) - count($this->imagesToDelete);
                if ($totalImages < 10) {
                    $this->images[] = $newImage;
                }
            }
        }

        // Check if limit exceeded
        $totalImages = count($this->existingImages) + count($this->images) - count($this->imagesToDelete);
        if ($totalImages > 10) {
            $excess = $totalImages - 10;
            $this->images = array_slice($this->images, 0, count($this->images) - $excess);
            session()->flash('warning', 'Maximum 10 images allowed.');
        }

        // Reset the newImages to allow for more uploads
        $this->reset('newImages');
    }

    public function removeNewImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images); // Re-index array
        }
    }

    public function removeExistingImage($imageId)
    {
        $image = $this->existingImages->find($imageId);
        if ($image) {
            $this->imagesToDelete[] = $imageId;
        }
    }

    public function restoreExistingImage($imageId)
    {
        $key = array_search($imageId, $this->imagesToDelete);
        if ($key !== false) {
            unset($this->imagesToDelete[$key]);
            $this->imagesToDelete = array_values($this->imagesToDelete);
        }
    }

    public function updatePost()
    {
        $this->validate();

        try {
            // Update the post content
            $this->post->update([
                'konten' => $this->konten,
            ]);

            // Handle image deletions
            if (!empty($this->imagesToDelete)) {
                $imagesToDelete = GambarPost::whereIn('id', $this->imagesToDelete)->get();
                foreach ($imagesToDelete as $image) {
                    // Delete file from storage
                    if (Storage::disk('public')->exists($image->url)) {
                        Storage::disk('public')->delete($image->url);
                    }
                    // Delete record from database
                    $image->delete();
                }
            }

            // Upload and save new images
            if (!empty($this->images)) {
                foreach ($this->images as $image) {
                    // Store image in public disk under 'posts' directory
                    $path = $image->store('posts', 'public');

                    // Save image record
                    GambarPost::create([
                        'url' => $path,
                        'post_id' => $this->post->id,
                    ]);
                }
            }

            session()->flash('success', 'Post updated successfully!');

            return $this->redirect(route('profile'), navigate: true);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update post. Please try again.');
        }
    }

    public function getTotalImagesProperty()
    {
        return count($this->existingImages) + count($this->images) - count($this->imagesToDelete);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.edit');
    }
}