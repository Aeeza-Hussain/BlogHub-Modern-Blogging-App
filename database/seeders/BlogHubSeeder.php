<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Author;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlogHubSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Create Default Demo Users
        User::firstOrCreate(
            ['email' => 'aleezeh16@gmail.com'],
            ['name' => 'Aleeza Fatima', 'password' => Hash::make('password'), 'user_type' => 1]
        );

        User::firstOrCreate(
            ['email' => 'admin@bloghub.com'],
            ['name' => 'BlogHub Admin', 'password' => Hash::make('password'), 'user_type' => 1]
        );

        User::firstOrCreate(
            ['email' => 'author@bloghub.com'],
            ['name' => 'Sarah Author', 'password' => Hash::make('password'), 'user_type' => 2]
        );

        // 1. Create 10 Categories
        $categoriesData = [
            ['name' => 'Technology', 'icon' => 'fa-laptop-code', 'description' => 'Latest trends in software, AI, hardware, and web development.', 'color' => '#1F2A44'],
            ['name' => 'Design & UX', 'icon' => 'fa-palette', 'description' => 'UI design systems, typography, color theory, and user experience.', 'color' => '#C8461F'],
            ['name' => 'Travel', 'icon' => 'fa-compass', 'description' => 'Guides, culture, destination reviews, and travel tips across the globe.', 'color' => '#3F5A45'],
            ['name' => 'Food & Cooking', 'icon' => 'fa-utensils', 'description' => 'Delicious recipes, culinary secrets, and restaurant reviews.', 'color' => '#D97706'],
            ['name' => 'Business', 'icon' => 'fa-chart-line', 'description' => 'Startups, entrepreneurship, market trends, and growth strategies.', 'color' => '#2563EB'],
            ['name' => 'Sports & Fitness', 'icon' => 'fa-running', 'description' => 'Athletic achievements, workout routines, and wellness advice.', 'color' => '#DC2626'],
            ['name' => 'Health & Wellness', 'icon' => 'fa-heartbeat', 'description' => 'Mindfulness, nutrition, mental health, and healthy living.', 'color' => '#059669'],
            ['name' => 'AI & Innovation', 'icon' => 'fa-brain', 'description' => 'Machine learning, robotics, and futuristic technology insights.', 'color' => '#7C3AED'],
            ['name' => 'Culture & Lifestyle', 'icon' => 'fa-book-open', 'description' => 'Books, movies, philosophy, and modern lifestyle trends.', 'color' => '#DB2777'],
            ['name' => 'Finance', 'icon' => 'fa-coins', 'description' => 'Personal finance, investing, crypto, and economic news.', 'color' => '#0D9488'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[] = Category::create([
                'name' => $c['name'],
                'slug' => Str::slug($c['name']),
                'icon' => $c['icon'],
                'description' => $c['description'],
                'color' => $c['color'],
            ]);
        }

        // 2. Create 8 Authors
        $authorsData = [
            [
                'name' => 'Devon Lane',
                'tagline' => 'Senior Tech Journalist & AI Researcher',
                'bio' => 'Passionate about artificial intelligence, frontend architectures, and the evolution of web technology.',
                'specialty' => 'Technology & AI',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                'followers_count' => 1420,
                'following_count' => 180,
            ],
            [
                'name' => 'Amina Al-Mansoor',
                'tagline' => 'UX Design Strategist & Typography Enthusiast',
                'bio' => 'Building accessible, elegant user interfaces and writing about modern design systems.',
                'specialty' => 'Design & UX',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80',
                'followers_count' => 2890,
                'following_count' => 210,
            ],
            [
                'name' => 'Marcus Vance',
                'tagline' => 'Global Travel Writer & Photographer',
                'bio' => 'Documenting hidden gems, mountain trails, and cultural stories from 45+ countries.',
                'specialty' => 'Travel & Culture',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1200&q=80',
                'followers_count' => 980,
                'following_count' => 95,
            ],
            [
                'name' => 'Elena Rostova',
                'tagline' => 'Executive Chef & Culinary Author',
                'bio' => 'Exploring traditional European recipes with a modern twist. Author of 2 bestselling cookbooks.',
                'specialty' => 'Food & Cooking',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80',
                'followers_count' => 3120,
                'following_count' => 140,
            ],
            [
                'name' => 'Jonathan Hayes',
                'tagline' => 'Venture Capital Analyst & Business Strategist',
                'bio' => 'Analyzing SaaS economics, startup fundraising, and market disruption strategies.',
                'specialty' => 'Business & Finance',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                'followers_count' => 1750,
                'following_count' => 310,
            ],
            [
                'name' => 'Sarah Lin',
                'tagline' => 'Bio-Hacking & Holistic Health Researcher',
                'bio' => 'Writing evidence-based articles on sleep quality, mental endurance, and longevity.',
                'specialty' => 'Health & Wellness',
                'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=300&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=1200&q=80',
                'followers_count' => 2410,
                'following_count' => 165,
            ],
            [
                'name' => 'Carlos Mendez',
                'tagline' => 'Marathon Runner & High Performance Coach',
                'bio' => 'Helping endurance athletes reach peak physical performance through structured training.',
                'specialty' => 'Sports & Fitness',
                'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=300&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1200&q=80',
                'followers_count' => 840,
                'following_count' => 110,
            ],
            [
                'name' => 'Priya Sharma',
                'tagline' => 'Fintech Innovator & Crypto Analyst',
                'bio' => 'Unpacking decentralized systems, algorithmic trading, and modern wealth building.',
                'specialty' => 'Finance & Crypto',
                'avatar' => 'https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?auto=format&fit=crop&w=300&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1200&q=80',
                'followers_count' => 1930,
                'following_count' => 220,
            ],
        ];

        $authors = [];
        foreach ($authorsData as $a) {
            $authors[] = Author::create([
                'name' => $a['name'],
                'slug' => Str::slug($a['name']),
                'avatar' => $a['avatar'],
                'cover_image' => $a['cover_image'],
                'tagline' => $a['tagline'],
                'bio' => $a['bio'],
                'specialty' => $a['specialty'],
                'followers_count' => $a['followers_count'],
                'following_count' => $a['following_count'],
            ]);
        }

        // 3. Create 20+ Articles
        $articlesSeed = [
            [
                'title' => 'The Next Era of Generative AI: Beyond Large Language Models',
                'category_id' => $categories[0]->id, // Tech
                'author_id' => $authors[0]->id, // Devon
                'is_featured' => true,
                'is_trending' => true,
                'reading_time' => 7,
                'views_count' => 4820,
                'likes_count' => 642,
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Exploring multimodal neural architectures, spatial computing integrations, and autonomous software agents shaping tomorrow.',
            ],
            [
                'title' => 'Mastering Design Systems in 2026: From Tokens to Components',
                'category_id' => $categories[1]->id, // Design
                'author_id' => $authors[1]->id, // Amina
                'is_featured' => true,
                'is_trending' => true,
                'reading_time' => 6,
                'views_count' => 3210,
                'likes_count' => 512,
                'image' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'A practical blueprint for architecting scalable CSS design tokens, responsive typography grids, and accessible components.',
            ],
            [
                'title' => 'Exploring the Hidden Fjords of Norway: A Photographer’s Guide',
                'category_id' => $categories[2]->id, // Travel
                'author_id' => $authors[2]->id, // Marcus
                'is_featured' => true,
                'is_trending' => false,
                'reading_time' => 8,
                'views_count' => 2940,
                'likes_count' => 380,
                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Off-the-beaten-path hiking routes, lighting recommendations, and local lodge secrets for capturing Arctic landscape splendor.',
            ],
            [
                'title' => 'The Art of Sourdough Fermentation: Temperature, Hydration & Crust',
                'category_id' => $categories[3]->id, // Food
                'author_id' => $authors[3]->id, // Elena
                'is_featured' => false,
                'is_trending' => true,
                'reading_time' => 5,
                'views_count' => 1890,
                'likes_count' => 290,
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Unlocking the biochemical magic behind wild yeast starters, open crumb structures, and golden crispy sourdough crusts.',
            ],
            [
                'title' => 'SaaS Metrics That Matter: Retention, LTV, and CAC Breakdown',
                'category_id' => $categories[4]->id, // Business
                'author_id' => $authors[4]->id, // Jonathan
                'is_featured' => false,
                'is_trending' => true,
                'reading_time' => 9,
                'views_count' => 4120,
                'likes_count' => 450,
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Why net dollar retention is the single most critical metric for early-stage software companies aiming for Series A.',
            ],
            [
                'title' => 'Building Deep Focus & Mental Endurance in a Distracted World',
                'category_id' => $categories[6]->id, // Health
                'author_id' => $authors[5]->id, // Sarah
                'is_featured' => false,
                'is_trending' => false,
                'reading_time' => 6,
                'views_count' => 1540,
                'likes_count' => 210,
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Neuroscience-backed protocols for entering deep work flow states, managing circadian rhythms, and reducing digital cognitive fatigue.',
            ],
            [
                'title' => 'Training for Your First 50K Ultra-Marathon: Weekly Periodization',
                'category_id' => $categories[5]->id, // Sports
                'author_id' => $authors[6]->id, // Carlos
                'is_featured' => false,
                'is_trending' => false,
                'reading_time' => 10,
                'views_count' => 1120,
                'likes_count' => 175,
                'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'How to scale your long runs safely, manage trail nutrition, and prevent overuse injuries during peak training blocks.',
            ],
            [
                'title' => 'Decentralized Finance vs Traditional Banking: The 2026 Shift',
                'category_id' => $categories[9]->id, // Finance
                'author_id' => $authors[7]->id, // Priya
                'is_featured' => false,
                'is_trending' => false,
                'reading_time' => 7,
                'views_count' => 2340,
                'likes_count' => 310,
                'image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Examining smart contract yields, automated market makers, and regulatory frameworks reshaping international banking.',
            ],
        ];

        // Fill up 22 total articles with varied titles
        $extraTitles = [
            'Micro-Frontends in 2026: Architecture & Lessons Learned',
            'Color Psychology in Mobile App Onboarding Flows',
            'Solo Backpacking Through Patagonia: Route Prep & Advice',
            'Plant-Based Protein Guide for High Performance Athletes',
            'Bootstrapping to $1M ARR: Zero VC Funding Playbook',
            'Circadian Biology: Light Exposure Protocols for Sleep',
            'VO2 Max Optimization: HIIT vs Zone 2 Endurance',
            'Algorithmic Trading Strategies for Retail Investors',
            'Quantum Computing Milestones: What Engineers Must Know',
            'Accessible Web Forms: ARIA Labels & Keyboard Traps',
            'Cultural Heritage of Kyoto: Temples, Tea & Gardens',
            'Artisanal Coffee Roasting: Light vs Dark Roast Chemistry',
            'Remote Team Culture: Asynchronous Work Best Practices',
            'Cold Water Immersion: Physiology & Recovery Benefits',
        ];

        $i = 0;
        foreach ($articlesSeed as $seed) {
            $art = Article::create([
                'title' => $seed['title'],
                'slug' => Str::slug($seed['title']),
                'category_id' => $seed['category_id'],
                'author_id' => $seed['author_id'],
                'is_featured' => $seed['is_featured'],
                'is_trending' => $seed['is_trending'],
                'reading_time' => $seed['reading_time'],
                'views_count' => $seed['views_count'],
                'likes_count' => $seed['likes_count'],
                'featured_image' => $seed['image'],
                'excerpt' => $seed['excerpt'],
                'body' => $this->generateDummyBody($seed['title']),
                'published_at' => now()->subDays(rand(1, 45)),
            ]);

            $this->seedCommentsForArticle($art->id);
            $i++;
        }

        foreach ($extraTitles as $idx => $t) {
            $cat = $categories[$idx % count($categories)];
            $aut = $authors[$idx % count($authors)];
            $art = Article::create([
                'title' => $t,
                'slug' => Str::slug($t),
                'category_id' => $cat->id,
                'author_id' => $aut->id,
                'is_featured' => false,
                'is_trending' => ($idx % 3 === 0),
                'reading_time' => rand(4, 9),
                'views_count' => rand(500, 3500),
                'likes_count' => rand(40, 400),
                'featured_image' => 'https://picsum.photos/seed/' . Str::slug($t) . '/1200/675',
                'excerpt' => 'A comprehensive deep dive into ' . strtolower($t) . ', providing actionable frameworks, empirical research, and expert commentary.',
                'body' => $this->generateDummyBody($t),
                'published_at' => now()->subDays(rand(2, 60)),
            ]);

            $this->seedCommentsForArticle($art->id);
        }
    }

    private function seedCommentsForArticle($articleId)
    {
        $commenters = [
            ['name' => 'Alex Turner', 'avatar' => 'https://i.pravatar.cc/150?img=11', 'text' => 'This is one of the most thorough breakdowns I have read this month. Excellent work!'],
            ['name' => 'Sophia Chen', 'avatar' => 'https://i.pravatar.cc/150?img=22', 'text' => 'The code examples and visual design takeaways were incredibly clear. Saved to my reading list!'],
            ['name' => 'David Miller', 'avatar' => 'https://i.pravatar.cc/150?img=33', 'text' => 'Appreciate the practical perspective here. Would love a follow-up article on this topic.'],
            ['name' => 'Jessica Taylor', 'avatar' => 'https://i.pravatar.cc/150?img=44', 'text' => 'Great insights. I’ve implemented a similar strategy in my team with remarkable results.'],
        ];

        foreach ($commenters as $c) {
            Comment::create([
                'article_id' => $articleId,
                'user_name' => $c['name'],
                'user_avatar' => $c['avatar'],
                'content' => $c['text'],
            ]);
        }
    }

    private function generateDummyBody($title)
    {
        return '
            <p class="lead fw-semibold text-secondary">In this article, we take an exhaustive look at ' . e($title) . ', breaking down key technical concepts, real-world case studies, and actionable takeaways for modern practitioners.</p>
            
            <h2 class="mt-4 mb-3 font-heading">1. Introduction & Context</h2>
            <p>As digital ecosystems evolve, understanding the core principles behind ' . e($title) . ' has become paramount. Whether you are leading a team or building independently, mastering these concepts will set your work apart.</p>
            
            <blockquote class="blockquote my-4 p-4 border-start border-4 border-primary bg-light-subtle rounded">
                <p class="mb-0 italic">"Simplicity is prerequisite for reliability, and clarity of design is what turns great ideas into lasting platforms."</p>
                <footer class="blockquote-footer mt-2 font-mono">BlogHub Editorial Insights</footer>
            </blockquote>

            <h2 class="mt-4 mb-3 font-heading">2. Code Implementation & Best Practices</h2>
            <p>Below is a clean snippet demonstrating how key state transitions and component boundaries are managed:</p>

<pre><code class="language-javascript">// BlogHub Feature Handler
function executeArchitecturePattern(config) {
    const { token, mode, options } = config;
    if (!token) throw new Error("Invalid access token");

    return {
        status: "success",
        timestamp: new Date().toISOString(),
        payload: { mode, options }
    };
}
</code></pre>

            <h2 class="mt-4 mb-3 font-heading">3. Key Takeaways & Recommendations</h2>
            <ul>
                <li>Maintain clean separation of concerns between business logic and UI presentation.</li>
                <li>Leverage semantic HTML5 landmarks and accessible ARIA labels across all view states.</li>
                <li>Optimize performance through responsive image assets and minimal render-blocking assets.</li>
            </ul>
            <p>By enforcing these principles, you ensure maximum long-term scalability and maintainability for your web applications.</p>
        ';
    }
}
