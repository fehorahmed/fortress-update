<?php

namespace App\Http\Controllers;

use App\Models\DocumentationInfo;
use App\Models\DocumentationInfoImages;
use App\Models\Project;
use App\Models\ProjectGallary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class DocumentationController extends Controller
{
    public function index()
    {
        $projects = Project::where('id',Auth::user()->project_id)->get();

        return view('documentation.info.all', compact('projects'));
    }

    public function projectView(Project $project)
    {

        $documentationInfos = DocumentationInfo::where('project_id', Auth::user()->project_id)->get();
        return view('documentation.view.all', compact('documentationInfos', 'project'));
    }

    public function add(Project $project)
    {

        return view('documentation.info.add', compact('project'));
    }

    public function addPost(Project $project, Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'images.*' => 'image',
        ]);
        $imagePath = null;
        $info = new DocumentationInfo();
        $info->name = $request->name;
        $info->project_id = $project->id;
        $info->description = $request->description;
        $info->user_id = Auth::id();
        $info->save();

        if ($files = $request->file('images')) {

            foreach ($files as $file) {
                // Upload Image
                // $file = $request->file('image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/documentation';
                $file->move($destinationPath, $filename);
                $imagePath = 'uploads/documentation/' . $filename;
                $infoImage = new DocumentationInfoImages();

                $infoImage->documentation_info_id = $info->id;
                $infoImage->image = $imagePath;
                $infoImage->details = '';
                $infoImage->save();
            }
        }

        return redirect()->route('documentation.project.view', ['project' => $project->id])->with('message', 'Documentation added successfully');
    }

    public function edit(DocumentationInfo $info)
    {
        $infoImages= DocumentationInfoImages::where('documentation_info_id', $info->id)->get();

        return view('documentation.info.edit', compact('info','infoImages'));
    }

    public function editPost(DocumentationInfo $info, Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            //'images.*' => 'nullable|image',
        ]);
        $imagePath = null;
      ///  $info = new DocumentationInfo();
        $info->name = $request->name;
        //$info->project_id = $project->id;
        $info->description = $request->description;
        $info->save();

        if ($files = $request->file('images')) {

           // dd('sdsd');
            $deleteImages = DocumentationInfoImages::where('documentation_info_id',$info->id)->get();

            if($deleteImages){
               // dd('aseee');
                foreach ($deleteImages as $key => $deleteImage) {
                    if(file_exists(public_path($deleteImage->image))){
                        unlink(public_path($deleteImage->image));
                    }
                }
            }

            $deleteImages = DocumentationInfoImages::where('documentation_info_id',$info->id)->delete();
           // dd('ssss');
            foreach ($files as $file) {
                // Upload Image
                // $file = $request->file('image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/documentation';
                $file->move($destinationPath, $filename);
                $imagePath = 'uploads/documentation/' . $filename;
                $infoImage = new DocumentationInfoImages();

                $infoImage->documentation_info_id = $info->id;
                $infoImage->image = $imagePath;
                $infoImage->details = '';
                $infoImage->save();
            }
        }

        return redirect()->back()->with('message', 'Documentation added successfully');
    }


    public function gallaryAll(){
        $projects = Project::where('id',Auth::user()->project_id)->get();

        return view('documentation.gallary.all', compact('projects'));
    }

    public function gallaryViewAdd(Project $project){

        $projectImages= ProjectGallary::where('project_id', Auth::user()->project_id)->get();

        return view('documentation.gallary.add',compact('project','projectImages'));
    }

    public function gallaryAdd(Project $project, Request $request){


        $request->validate([

            'description' => 'nullable',
            'images' => 'required',
            'images.*' => 'mimes:jpeg,jpg,png|max:2048'
        ]);

        if($request->hasFile('images')){

            foreach ($request->file('images') as $file ) {

                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/gallery';
                $file->move($destinationPath, $filename);
                $imagePath = 'uploads/gallery/' . $filename;
                $projectImage = new ProjectGallary();

                $projectImage->project_id = $project->id;
                $projectImage->image = $imagePath;
                $projectImage->description = $request->description;
                $projectImage->save();

            }

            return redirect()->back()->with('message','Images Added Successfully.');
        }

        return redirect()->back()->with('message','No Image Selected.');

    }


    public function gallaryDelete(ProjectGallary $gallery){


        if($gallery){

                 if(file_exists(public_path($gallery->image))){
                     unlink(public_path($gallery->image));
                 }

         }
         ProjectGallary::where('id',Auth::user()->project_id)->where('id',$gallery->id)->delete();
         return redirect()->back()->with('message', 'Delete successfully');

        //dd($gallery);

    }


}
