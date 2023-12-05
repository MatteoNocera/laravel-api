<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GitHubController extends Controller
{
    public function fetchRepo()
    {
        $username = config('services.github.username');
        $response = Http::withoutVerifying()->withHeader('Authorization', 'Bearer ' .  env('GITHUB_AUTH_TOKEN'))->get("https://api.github.com/users/$username/repos?sort=created&direction=asc&per_page=100");

        if ($response->successful()) {
            $repositories = $response->json();

            DB::beginTransaction();

            try {
                foreach ($repositories as $repository) {
                    $slug = Str::slug($repository['name']);

                    $project = Project::updateOrCreate(
                        ['title' => $repository['name']],
                        [
                            'slug' => $slug,
                            'cover_image' => 'placeholders/WELEDyBspHjaOlvW1WV7xaetaKejmFZ0la2pw6jU.png',
                            'git_link' => $repository['html_url'],
                            'description' => $repository['description'],
                            'publication_date' => Carbon::parse($repository['created_at'])->format('y-m-d'),
                        ]
                    );

                    $languagesResponse = Http::withoutVerifying()->withHeader('Authorization', 'Bearer ' .  env('GITHUB_AUTH_TOKEN'))->get($repository['languages_url']);
                    if ($languagesResponse->successful()) {
                        $languages = array_keys($languagesResponse->json());

                        $technologyIds = [];
                        foreach ($languages as $language) {
                            $technology = Technology::firstOrCreate(['name' => $language], ['slug' => Str::slug($language)]);
                            $technologyIds[] = $technology->id;
                        }

                        // Aggiungo le tecnologie al progetto
                        $project->technologies()->sync($technologyIds);
                    }
                }

                DB::commit();
                return redirect()->route('admin.projects.index')->with('success', '✅ Repo fetch successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('admin.projects.index')->with('error', '❌ Repo fetch failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.projects.index')->with('error', '❌ Unable to fetch repositories from GitHub');
    }
}
