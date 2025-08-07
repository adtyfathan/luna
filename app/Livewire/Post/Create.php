<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\GambarPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads;

    public $konten = '';
    public $images = [];
    public $newImages = [];

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

    public function mount()
    {
        $this->images = [];
    }

    public function updatedNewImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:5120',
        ]);

        // Add new images to existing images array
        if (!empty($this->newImages)) {
            foreach ($this->newImages as $newImage) {
                if (count($this->images) < 10) {
                    $this->images[] = $newImage;
                }
            }
        }

        // Check if limit exceeded
        if (count($this->images) > 10) {
            $this->images = array_slice($this->images, 0, 10);
            session()->flash('warning', 'Maximum 10 images allowed.');
        }

        // Reset the newImages to allow for more uploads
        $this->reset('newImages');
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images); // Re-index array
        }
    }

    public function createPost()
    {
        $this->validate();

        try {
            // Create the post
            $post = Post::create([
                'konten' => $this->konten,
                'author_type' => 'App\Models\User',
                'author_id' => Auth::id(),
            ]);

            // Upload and save images
            if (!empty($this->images)) {
                foreach ($this->images as $image) {
                    // Store image in public disk under 'posts' directory
                    $path = $image->store('posts', 'public');

                    // Save image record
                    GambarPost::create([
                        'url' => $path,
                        'post_id' => $post->id,
                    ]);
                }
            }

            // Reset form
            $this->reset(['konten', 'images', 'newImages']);

            session()->flash('success', 'Post created successfully!');

            return $this->redirect(route('profile'), navigate: true);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create post. Please try again.');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.create');
    }
}