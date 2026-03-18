<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\SearchHistory;
use App\Models\PopularSearch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class SearchAutocomplete extends Component
{
    public string $query = '';
    
    /** @var Collection<int, Product> */
    public Collection $results;
    
    /** @var Collection<int, Category> */
    public Collection $categories;
    
    public bool $showResults = false;
    public int $selectedIndex = -1;
    
    /** @var array<int, string> */
    public array $recentSearches = [];
    
    /** @var array<int, string> */
    public array $popularSearches = [];

    public function mount(): void
    {
        // Initialiser les collections vides
        $this->results = collect();
        $this->categories = collect();
        
        $this->loadRecentSearches();
        $this->loadPopularSearches();
    }

    public function updatedQuery(): void
    {
        $this->selectedIndex = -1;

        if (strlen($this->query) >= 2) {
            // Recherche produits avec query builder réutilisable
            $productsQuery = Product::with('category')
                ->where(function($query) {
                    $query->where('name', 'like', '%' . $this->query . '%')
                          ->orWhere('short_description', 'like', '%' . $this->query . '%')
                          ->orWhere('description', 'like', '%' . $this->query . '%');
                })
                ->where('stock', '>', 0);

            // Prendre 6 produits pour l'affichage dans le dropdown
            $this->results = $productsQuery->limit(6)->get();

            // Récupérer TOUS les produits matchant pour les catégories
            $allMatchingProducts = $productsQuery->get();
            
            // Grouper par catégorie et compter
            $categoryStats = $allMatchingProducts->groupBy('category_id')
                ->map(function($products) {
                    $category = $products->first()->category;
                    // Ajouter un attribut dynamique pour le compteur
                    $category->matching_products_count = $products->count();
                    return $category;
                })
                ->sortByDesc('matching_products_count') // Trier par pertinence
                ->take(3) // Limiter à 3 catégories
                ->values();

            $this->categories = $categoryStats;
            
            $this->showResults = true;

            // Enregistrer dans analytics
            $this->recordSearch();
        } else {
            $this->results = collect();
            $this->categories = collect();
            $this->showResults = false;
        }
    }

    public function loadRecentSearches(): void
    {
        if (Auth::check()) {
            $this->recentSearches = SearchHistory::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->pluck('query')
                ->unique()
                ->values()
                ->toArray();
        } else {
            $this->recentSearches = SearchHistory::where('session_id', session()->getId())
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->pluck('query')
                ->unique()
                ->values()
                ->toArray();
        }
    }

    public function loadPopularSearches(): void
    {
        $this->popularSearches = PopularSearch::orderBy('search_count', 'desc')
            ->take(5)
            ->pluck('query')
            ->toArray();
    }

    public function recordSearch(): void
    {
        // Enregistrer dans l'historique
        SearchHistory::create([
            'user_id' => Auth::id(),
            'session_id' => Auth::check() ? null : session()->getId(),
            'query' => $this->query,
            'results_count' => $this->results->count(),
        ]);

        // Mettre à jour les recherches populaires
        $popularSearch = PopularSearch::firstOrNew(
            ['query' => strtolower($this->query)]
        );
        
        if ($popularSearch->exists) {
            $popularSearch->increment('search_count');
            $popularSearch->update(['last_searched_at' => now()]);
        } else {
            $popularSearch->search_count = 1;
            $popularSearch->last_searched_at = now();
            $popularSearch->save();
        }
    }

    public function selectProduct(int $productId)
    {
        // Incrémenter le compteur de clics
        if ($this->query) {
            PopularSearch::where('query', strtolower($this->query))
                ->increment('click_count');
        }

        $product = Product::find($productId);
        if ($product) {
            return redirect()->route('product.show', $product);
        }
    }

    public function selectCategory(string $categorySlug)
    {
        // Rediriger vers la boutique avec filtre catégorie + recherche
        return redirect()->route('shop', [
            'category' => $categorySlug,
            'search' => $this->query
        ]);
    }

    public function selectRecentSearch(string $query): void
    {
        $this->query = $query;
        $this->updatedQuery();
    }

    public function clearHistory(): void
    {
        if (Auth::check()) {
            SearchHistory::where('user_id', Auth::id())->delete();
        } else {
            SearchHistory::where('session_id', session()->getId())->delete();
        }
        $this->recentSearches = [];
    }

    public function search()
    {
        if (strlen($this->query) >= 2) {
            $this->recordSearch();
            return redirect()->route('shop', ['search' => $this->query]);
        }
    }

    public function closeResults(): void
    {
        $this->showResults = false;
        $this->selectedIndex = -1;
    }

    // Navigation clavier
    public function moveUp(): void
    {
        $totalItems = $this->categories->count() + $this->results->count();
        if ($this->selectedIndex > 0) {
            $this->selectedIndex--;
        } else {
            $this->selectedIndex = $totalItems - 1; // Boucle vers le bas
        }
    }

    public function moveDown(): void
    {
        $totalItems = $this->categories->count() + $this->results->count();
        if ($this->selectedIndex < $totalItems - 1) {
            $this->selectedIndex++;
        } else {
            $this->selectedIndex = 0; // Boucle vers le haut
        }
    }

    public function selectCurrent()
    {
        if ($this->selectedIndex < 0) {
            return $this->search();
        }

        $totalCategories = $this->categories->count();
        
        if ($this->selectedIndex < $totalCategories) {
            // Catégorie sélectionnée
            $category = $this->categories[$this->selectedIndex];
            return $this->selectCategory($category->slug);
        } else {
            // Produit sélectionné
            $productIndex = $this->selectedIndex - $totalCategories;
            if (isset($this->results[$productIndex])) {
                $product = $this->results[$productIndex];
                return $this->selectProduct($product->id);
            }
        }
    }

    public function render()
    {
        return view('livewire.search-autocomplete');
    }
}