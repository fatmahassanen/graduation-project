@extends('layouts.app')

@section('title', 'Quality Assurance - NCTU')

@section('content')

<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Quality Assurance</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Quality Assurance</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-2xl font-bold mb-6" style="color: #1a096e; border-bottom: 3px solid #D08301; padding-bottom: 12px;">Quality Assurance Resources</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('quality.intro') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Introduction to the Quality Assurance Unit</span>
                        </a>
                        
                        <a href="{{ route('quality.vision') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Vision and Mission</span>
                        </a>
                        
                        <a href="{{ route('quality.periodical-pub') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>The Unit's Periodical Publication</span>
                        </a>
                        
                        <a href="{{ route('quality.tasks') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Unit Tasks and Objectives</span>
                        </a>
                        
                        <a href="{{ route('quality.regulations') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Internal Regulations of the Unit</span>
                        </a>
                        
                        <a href="{{ route('quality.org-structure') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Organizational Structure and Responsibilities</span>
                        </a>
                        
                        <a href="{{ route('quality.executive-council') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Executive Council</span>
                        </a>
                        
                        <a href="{{ route('quality.admin-council') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Formation of the Administrative Council</span>
                        </a>
                        
                        <a href="{{ route('quality.academic-standards') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Academic Standards</span>
                        </a>
                        
                        <a href="{{ route('quality.activities') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Unit Activities</span>
                        </a>
                        
                        <a href="{{ route('quality.courses-workshops') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all" style="color: #333; display: flex; text-decoration: none;">
                            <i class="fas fa-chevron-right text-blue-500"></i>
                            <span>Courses and Workshops</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
