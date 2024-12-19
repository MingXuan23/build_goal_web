<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;  

class JobScraperController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function indexJobStreet()
    {
        return view('jobstreet.index');
    }

    public function fetchJobs(Request $request)
    {
        try {
            $page = $request->query('page', 1);
            $query = $request->query('query');
            $address = $request->query('address');
            
            if ($address) {
                $address = str_replace(' ', '-', $address);
            }
            if ($query) {
                $query = str_replace(' ', '-', $query);
            }
            
            $page = min($page, 100);
            $page = (int)$page;
            
            if ($query && $address) {
                $url = "https://my.jobstreet.com/$query-jobs/in-$address?page=$page";
                $url2 = "https://my.jobstreet.com/$query-jobs/in-$address?page=2";
            } elseif ($query) {
                $url = "https://my.jobstreet.com/$query-jobs?page=$page";
                $url2 = "https://my.jobstreet.com/$query-jobs?page=2";
            } elseif ($address) {
                $url = "https://my.jobstreet.com/jobs/in-$address?page=$page";
                $url2 = "https://my.jobstreet.com/jobs/in-$address?page=2";
            } else {
                $url = "https://my.jobstreet.com/jobs?page=20";
                $url2 = "https://my.jobstreet.com/jobs?page=2";
            }
            
    
        $headers = [
            'Host' =>  'my.jobstreet.com',
            'Cookie' =>  'sol_id=dac5beaa-7e2b-4d26-baa6-5de4aadd57db; JobseekerSessionId=5e945a76-afb7-405d-8fa6-f4a06137a8ab; JobseekerVisitorId=5e945a76-afb7-405d-8fa6-f4a06137a8ab; _cfuvid=LLbpFw8VcSAdh.fmL.ync5fpFV5BYeGEzI0Ou0FGU7k-1734249438490-0.0.1.1-604800000; da_searchTerm=undefined; _tt_enable_cookie=1; _ttp=KXuilr5q5uyQUtGWkUbD4GOTDDo.tt.1; ajs_anonymous_id=6cc9e0dd58347e93d478e7010522b567; _fbp=fb.1.1734249427917.839044789339192617; _hjHasCachedUserAttributes=true; _gcl_au=1.1.335630527.1734249428; _hjSessionUser_390553=eyJpZCI6IjYwYmNmNDgyLWFlMjItNTEwNi05MDg5LWZkMmNiMzg0NjgwMCIsImNyZWF0ZWQiOjE3MzQyNDk0Mjc5NjQsImV4aXN0aW5nIjp0cnVlfQ==; _hjSession_390553=eyJpZCI6IjE3YjI3M2E3LTMwZWUtNDhlNC1hNDYyLTViMjgwMjRhZDQyOSIsImMiOjE3MzQyNTQxMTg5NDksInMiOjAsInIiOjAsInNiIjowLCJzciI6MCwic2UiOjAsImZzIjowLCJzcCI6MH0=; __gads=ID=315bdfe43ec5a55c:T=1734250358:RT=1734254135:S=ALNI_MYq_IO06Rao1BwM6uChDT0iMcay8A; __gpi=UID=00000f91be8472c9:T=1734250358:RT=1734254135:S=ALNI_MZgel27kLvfmswHXuE5nZ0NvYQg1w; __eoi=ID=ffe4db49fa86bb17:T=1734250358:RT=1734254135:S=AA-AfjY4d14CZJYpFe3FHWkkJVLP; __cf_bm=m.AWn68CysKoZAAJn0gq9i.jpLqprMTY9_iw1FNPULU-1734254135-1.0.1.1-.xebXDlDe.tECrU53fJq.BJqmv1SVUkbWXu8FeWGQNlanjRs5eah5paO4VfvU.EI.RE.01kiSow9vnxrTD3B6w; da_sa_candi_sid=1734254121682; da_cdt=visid_0193c9522fd3002301334ea8e74005073001d06b00bd0-sesid_1734254121682-hbvid_dac5beaa_7e2b_4d26_baa6_5de4aadd57db-tempAcqSessionId_1734254121674-tempAcqVisitorId_dac5beaa7e2b4d26baa65de4aadd57db; main=V%7C2~P%7Cjobsearch~OSF%7Cquick&set=1734254126046/V%7C2~P%7Cjobsearch~K%7Caccount~OSF%7Cquick&set=1734254118856/V%7C2~P%7Cjobsearch~K%7Caccount~I%7C1203~OSF%7Cquick&set=1734250537465; utag_main=v_id:0193c9522fd3002301334ea8e74005073001d06b00bd0$_sn:2$_se:2%3Bexp-session$_ss:0%3Bexp-session$_st:1734255926898%3Bexp-session$ses_id:1734254121682%3Bexp-session$_pn:2%3Bexp-session$_prevpage:search%20results%3Bexp-1734257727028; hubble_temp_acq_session=id%3A1734254121674_end%3A1734255927033_sent%3A9; _hjMinimizedPolls=1525095; _dd_s=rum=0&expire=1734255030041&logs=0',
            'Cache-Control' =>  'max-age=0',
            'Sec-Ch-Ua' =>  '"Chromium";v="131", "Not_A Brand";v="24"',
            'Sec-Ch-Ua-Mobile' =>  '?0',
            'Sec-Ch-Ua-Platform' =>  '"Windows"',
            'Accept-Language' =>  'en-US,en;q=0.9',
            'Upgrade-Insecure-Requests' =>  '1',
            'User-Agent' =>  'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.86 Safari/537.36',
            'Accept' =>  'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Sec-Fetch-Site' =>  'none',
            'Sec-Fetch-Mode' =>  'navigate',
            'Sec-Fetch-User' =>  '?1',
            'Sec-Fetch-Dest' =>  'document',
            'Accept-Encoding' =>  'gzip, deflate, br',
            'Priority' =>  'u=0, i'
        ];
        $response = Http::withHeaders($headers)->get($url);

    
        $response2 = Http::withHeaders($headers)->get($url2);

        if ($response2->ok()) {
            $html = $response2->body();
            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);

            $totalJobs = $xpath->query('//span[@data-automation="totalJobsCount"]')->item(0);
            $totalJobs = $totalJobs ? trim($totalJobs->textContent) : 5;
            $totalJobs = str_replace(',', '', $totalJobs);
            $totalJobs = (int)$totalJobs;
        
        }else{
            $totalJobs = 0;
        }
    
        if ($response->ok()) {
            $html = $response->body();
            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);
    
            $jobTitles = $xpath->query('//h3[@class="_1unphw40 tcmsgw4z _1siu89c0 _1siu89c3 _1siu89c21 _9b1ltu4 _1siu89ca"]');
            $jobLinks = $xpath->query('//a[@data-automation="jobTitle"]');
            $articles = $xpath->query('//article[@data-job-id]');
    
            $jobs = [];
            $counter = 0;
    
            foreach ($jobTitles as $index => $title) {
                if ($counter >= 14) {
                    break;
                }
    
                $jobTitle = trim($title->textContent);
                $jobLink = $jobLinks->item($index)->getAttribute('href');
                $jobId = $articles->item($index)->getAttribute('data-job-id');
                $jobDetails = $this->getJobDetails($jobId);
    
                $jobs[] = array_merge([
                    'job_id' => $jobId,
                    'job_title' => $jobTitle,
                    'job_link' => "https://my.jobstreet.com$jobLink",
                ], $jobDetails);
    
                $counter++;
            }

            $totalPages = ceil($totalJobs / 14);
            return response()->json([
                'jobs' => $jobs,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_jobs' => $totalJobs,
            ]);
        }
        } catch (Exception $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    
        
    }
    

    private function getJobDetails($jobId)
    {
        $url = "https://my.jobstreet.com/job/$jobId?type=standard&ref=search-standalone&origin=cardTitle";

        $headers = [
            "Host" => "my.jobstreet.com",
            "Cache-Control" => "max-age=0",
            "Sec-Ch-Ua" => '"Chromium";v="131", "Not_A Brand";v="24"',
            "Sec-Ch-Ua-Mobile" => "?0",
            "Sec-Ch-Ua-Platform" => '"Windows"',
            "Accept-Language" => "en-US,en;q=0.9",
            "Upgrade-Insecure-Requests" => "1",
            "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.86 Safari/537.36",
            "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
            "Sec-Fetch-Site" => "none",
            "Sec-Fetch-Mode" => "navigate",
            "Sec-Fetch-User" => "?1",
            "Sec-Fetch-Dest" => "document",
            "Accept-Encoding" => "gzip, deflate, br",
            "Priority" => "u=0, i",
        ];
        
        $response = Http::withHeaders($headers)->get($url);
        if ($response->ok()) {
            $html = $response->body();
            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);

            preg_match('/"logo":\{"__typename":"JobProductBrandingImage","url":"(https:\\\\u002F\\\\u002Fimage-service-cdn.seek.com.au\\\\u002F[^"]+)"/', $response, $matches);

            $logo_url = isset($matches[1]) ? str_replace('\\u002F', '/', $matches[1]) : "Logo not found.";

            $jobTitleNode = $xpath->query('//h1[@data-automation="job-detail-title"]')->item(0);
            $jobTitle = $jobTitleNode ? trim($jobTitleNode->textContent) : 'Not available';

            $companyNameNode = $xpath->query('//span[@data-automation="advertiser-name"]')->item(0);
            $companyName = $companyNameNode ? trim($companyNameNode->textContent) : 'Not available';

            $locationNode = $xpath->query('//span[@data-automation="job-detail-location"]')->item(0);
            $location = $locationNode ? trim($locationNode->textContent) : 'Not available';

            $salaryNode = $xpath->query('//span[@data-automation="job-detail-salary"]')->item(0);
            $salary = $salaryNode ? trim($salaryNode->textContent) : 'Add expected salary to your profile for insights';

            $classificationsNode = $xpath->query('//span[@data-automation="job-detail-classifications"]')->item(0);
            $classifications = $classificationsNode ? trim($classificationsNode->textContent) : 'Not available';

            $workTypeNode = $xpath->query('//span[@data-automation="job-detail-work-type"]')->item(0);
            $workType = $workTypeNode ? trim($workTypeNode->textContent) : 'Not available';

            $jobDescriptionNode = $xpath->query('//div[@data-automation="jobAdDetails"]')->item(0);
            $jobDescription = $jobDescriptionNode ? trim($jobDescriptionNode->textContent) : 'No job description available';

            preg_match('/Posted\s.*?\sago/', $response, $matches1);
            $postedDate = isset($matches1[0]) ? trim($matches1[0]) : 'Not available';

            if ($postedDate === 'Add expected salary to your profile for insights') {
                $postedDate = '-';
            }

            return [
                'company_name' => $companyName,
                'location' => $location,
                'classifications' => $classifications,
                'work_type' => $workType,
                'salary' => $salary,
                'job_description' => $jobDescription,
                'posted_date' => $postedDate,
                'logo_url' => $logo_url,
            ];
        }

        return [
            'company_name' => 'Not available',
            'location' => 'Not available',
            'classifications' => 'Not available',
            'work_type' => 'Not available',
            'salary' => 'Not available',
            'job_description' => 'Not available',
            'posted_date' => 'Not available',
            'logo_url' => 'Logo not found.',
        ];
    }



    public function searchLocationsSuggest(Request $request)
    {
        // dd($request->all());
        $query1 = $request->input('query');
        // GraphQL URL
        $url = 'https://my.jobstreet.com/graphql';

        // Headers
        $headers = [
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br, zstd',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Connection' => 'keep-alive',
            'Content-Type' => 'application/json',
            'Origin' => 'https://my.jobstreet.com',
            'Referer' => 'https://my.jobstreet.com/a-jobs',
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-origin',
            'X-Seek-EC-SessionId' => '8a138868-9ef9-4126-ae78-7ba4a18227cd',
            'X-Seek-EC-VisitorId' => '8a138868-9ef9-4126-ae78-7ba4a18227cd',
            'X-Seek-Site' => 'chalice',
        ];

        $query = <<<'GRAPHQL'
        query searchLocationsSuggest($query: String!, $count: Int!, $recentLocation: String!, $locale: Locale, $country: CountryCodeIso2, $visitorId: UUID, $isRemoteEnabled: Boolean) {
          searchLocationsSuggest(
            query: $query
            count: $count
            recentLocation: $recentLocation
            locale: $locale
            country: $country
            visitorId: $visitorId
            isRemoteEnabled: $isRemoteEnabled
          ) {
            __typename
            suggestions {
              ... on LocationSuggestion {
                __typename
                text
                highlights {
                  start
                  end
                  __typename
                }
              }
              ... on LocationSuggestionGroup {
                __typename
                label
                suggestions {
                  text
                  highlights {
                    start
                    end
                    __typename
                  }
                  __typename
                }
                __typename
              }
            }
          }
        }
        GRAPHQL;

        // Request variables
        $variables = [
            'query' => $query1,
            'recentLocation' => '',
            'count' => 16,
            'locale' => 'en-MY',
            'country' => 'my',
            'visitorId' => '35af90d5-a519-4567-ad37-2a71db0d0c02',
            'isRemoteEnabled' => false,
        ];

        $response = Http::withHeaders($headers)
                        ->post($url, [
                            'operationName' => 'searchLocationsSuggest',
                            'query' => $query,
                            'variables' => $variables,
                        ]);

        $responseData = $response->json();

        return response()->json($responseData['data']['searchLocationsSuggest'] ?? []);
    }
}
