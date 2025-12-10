<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Copy default image to storage if it doesn't exist
     */
    private function ensureDefaultImage(): ?string
    {
        $sourcePath = public_path('images/product-image.webp');

        if (!file_exists($sourcePath)) {
            $this->command->warn('No default product image found at public/images/product-image.webp');
            return null;
        }

        // Ensure images directory exists in storage
        Storage::disk('public')->makeDirectory('images');

        $destination = 'images/product-image.webp';

        // Copy file if it doesn't exist
        if (!Storage::disk('public')->exists($destination)) {
            Storage::disk('public')->put($destination, file_get_contents($sourcePath));
            $this->command->info("Copied default image to storage: {$destination}");
        }

        return $destination;
    }

    public function run(): void
    {
        $brands = Brand::all()->keyBy('slug');
        $categories = Category::all()->keyBy('slug');

        if ($brands->isEmpty() || $categories->isEmpty()) {
            $this->call([BrandSeeder::class, CategorySeeder::class]);
            $brands = Brand::all()->keyBy('slug');
            $categories = Category::all()->keyBy('slug');
        }

        // Ensure default image exists in storage
        $this->ensureDefaultImage();

        $productData = [
            [
                'title' => 'Premium Nigerian Prince Subscription',
                'description' => 'Monthly letters from a totally real prince who just needs your help. Comes with handcrafted urgent subject lines.',
                'price' => 29.99,
                'brand' => 'nigerian-prince-llc',
                'category' => 'premium-scams',
                'is_featured' => true,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Regal email template'],
                ],
            ],
            [
                'title' => 'Crypto Rugpull Starter Kit',
                'description' => 'Everything you need to launch a token, pump it, and "go to the Bahamas". For educational purposes only.',
                'price' => 199.00,
                'brand' => 'cryptoklepto',
                'category' => 'digital-pranks',
                'is_featured' => true,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Crypto graph going up then down'],
                ],
            ],
            [
                'title' => 'Scamazon Empty Box Prime',
                'description' => 'Guaranteed 2-day delivery of a beautifully packaged empty box with convincing tracking updates.',
                'price' => 14.50,
                'brand' => 'scamazon-prime',
                'category' => 'revenge-packages',
                'is_featured' => true,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'An empty box with tape'],
                ],
            ],
            [
                'title' => 'Ponzi Pyramid Party Pack',
                'description' => 'A multi-level good time. Invite your friends and their friends and their friends to the opportunity of a lifetime.',
                'price' => 79.95,
                'brand' => 'ponzi-co',
                'category' => 'social-sabotage',
                'is_featured' => false,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Glorious pyramid diagram'],
                ],
            ],
            [
                'title' => 'Spamurai Inbox Slash',
                'description' => 'Unleash a wave of totally harmless, extremely annoying newsletters upon your nemesis.',
                'price' => 9.99,
                'brand' => 'spamurai',
                'category' => 'email-mayhem',
                'is_featured' => false,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Inbox flooded with spam'],
                ],
            ],
            [
                'title' => 'Fake Tech Support "Remote Help"',
                'description' => 'We slowly move desktop icons, change wallpapers, and whisper "have you tried turning it off and on again?".',
                'price' => 39.00,
                'brand' => 'fraudhub-labs',
                'category' => 'digital-pranks',
                'is_featured' => false,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Remote desktop prank'],
                ],
            ],
            [
                'title' => 'Social Media Blue Check Pretender',
                'description' => 'A collection of graphics and scripts to make anyone look dubiously verified for 24 hours.',
                'price' => 24.00,
                'brand' => 'deceivify',
                'category' => 'social-sabotage',
                'is_featured' => false,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Blue check imitation'],
                ],
            ],
            [
                'title' => 'ClickBait 1000 Headlines Bundle',
                'description' => 'You won’t believe number 7! A thousand ways to disappoint readers instantly.',
                'price' => 12.75,
                'brand' => 'clickbait-couture',
                'category' => 'email-mayhem',
                'is_featured' => false,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Clickbait headlines collage'],
                ],
            ],
            [
                'title' => 'Bogus Warranty Extension Calls',
                'description' => 'Robocalls about a car warranty for people who don’t even own a bike.',
                'price' => 16.40,
                'brand' => 'bogus-sons',
                'category' => 'phone-chaos',
                'is_featured' => false,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Phone call illustration'],
                ],
            ],
            [
                'title' => 'Phish & Giggles Starter Phishing Kit',
                'description' => 'Ridiculously obvious fake login pages for maximum laughs and minimal success.',
                'price' => 8.80,
                'brand' => 'phish-giggles',
                'category' => 'digital-pranks',
                'is_featured' => false,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Fake login page'],
                ],
            ],
            [
                'title' => 'Royal Instant Refund Service',
                'description' => 'We promise a refund that never arrives—just like your ex’s emotional maturity.',
                'price' => 54.99,
                'brand' => 'nigerian-prince-llc',
                'category' => 'premium-scams',
                'is_featured' => false,
                'images' => [
                    ['url' => 'images/product-image.webp', 'alt' => 'Refund form that goes nowhere'],
                ],
            ],
        ];

        foreach ($productData as $data) {
            $brand = $brands[$data['brand']] ?? null;
            $category = $categories[$data['category']] ?? null;

            $slug = Str::slug($data['title']);

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'is_available' => true,
                    'is_featured' => $data['is_featured'] ?? false,
                    'brand_id' => $brand?->id,
                    'category_id' => $category?->id,
                ]
            );

            if (!empty($data['images'])) {
                $hasPrimary = false;
                foreach ($data['images'] as $index => $img) {
                    $isPrimary = !$hasPrimary;
                    
                    // Remove 'storage/' prefix if present (we store paths without storage/ prefix)
                    $imageUrl = str_replace('storage/', '', $img['url']);
                    
                    ProductImage::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'url' => $imageUrl,
                        ],
                        [
                            'alt_text' => $img['alt'] ?? null,
                            'is_primary' => $isPrimary,
                        ]
                    );
                    $hasPrimary = true;
                }
            }
        }
    }
}


