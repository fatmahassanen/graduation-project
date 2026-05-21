<?php

namespace Database\Seeders;

use App\Models\Dean;
use Illuminate\Database\Seeder;

class DeansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dean 1 - Industrial and Energy Technology
        Dean::create([
            'full_name' => 'Professor Dr. Walid Al-Khatam',
            'title' => 'Professor',
            'position' => 'Dean of Industrial and Energy Technology',
            'faculty' => 'Faculty of Industrial and Energy Technology',
            'image' => null,
            'welcome_text' => "We are pleased to welcome you to the Faculty of Industrial and Energy Technology, where we believe that education is the foundation for building a better future.\nOur faculty is committed to preparing highly qualified graduates who combine strong academic knowledge with practical skills that meet the needs of the labor market.\nWe strive to provide a modern and inspiring learning environment that encourages creativity and innovation.\nWe look forward to seeing our students become active partners in success and continuous development.",
            'education' => "Ph.D. in Electrical Engineering, University of Waterloo, Canada – June 2005\nMaster's Degree in Electrical Engineering (Power and Electrical Machines), Ain Shams University, Egypt – 1996\nBachelor's Degree in Electrical Engineering (Power and Electrical Machines), Ain Shams University, Egypt – 1996",
            'experience' => "Professor, Department of Electrical Power and Machines Engineering, Faculty of Engineering, Ain Shams University, Egypt.\nConsultant for Electricity and Renewable Energy Development Programs in Egypt and Arab countries (since 2014).\nTechnical Consultant, Energy Excellence Center, Faculty of Engineering, Ain Shams University (2021-2023)\nVice Chairman, IEEE Power Engineering Society (PES) – Egypt Chapter (2020 – 2022)\nDirector, Energy Excellence Center, Faculty of Engineering, Ain Shams University (2019 - 2021)",
            'order' => 1,
        ]);

        // Dean 2 - Applied Health Sciences Technology
        Dean::create([
            'full_name' => 'Professor Dr. Ahmed Hassan',
            'title' => 'Professor',
            'position' => 'Dean of Applied Health Sciences Technology',
            'faculty' => 'Faculty of Applied Health Sciences Technology',
            'image' => null,
            'welcome_text' => "Welcome to the Faculty of Applied Health Sciences Technology. We are dedicated to advancing healthcare education through innovative technology and practical training.\nOur mission is to prepare healthcare professionals who can meet the evolving challenges of modern medicine.\nWe combine theoretical knowledge with hands-on experience to ensure our graduates are ready to make a meaningful impact in the healthcare sector.",
            'education' => "Ph.D. in Biomedical Engineering, Cairo University, Egypt – 2008\nMaster's Degree in Medical Technology, Alexandria University, Egypt – 2003\nBachelor's Degree in Biomedical Engineering, Cairo University, Egypt – 1999",
            'experience' => "Professor, Department of Biomedical Engineering, Cairo University\nConsultant for Healthcare Technology Development Programs (since 2015)\nMember of the Egyptian Society for Biomedical Engineering\nDirector of Medical Technology Research Center (2018-2020)",
            'order' => 2,
        ]);

        // Dean 3 - Students Affairs Vice Dean
        Dean::create([
            'full_name' => 'Dr. Mahmoud Ibrahim',
            'title' => 'Dr.',
            'position' => 'Students Affairs Vice Dean',
            'faculty' => 'Student Affairs Office',
            'image' => null,
            'welcome_text' => "Welcome to the Student Affairs Office at New Cairo Technological University.\nWe are here to support you throughout your academic journey and ensure you have the best possible university experience.\nOur team is dedicated to providing comprehensive student services, organizing activities, and fostering a vibrant campus community.\nWe believe in developing well-rounded individuals who excel both academically and personally.",
            'education' => "Ph.D. in Educational Administration, Helwan University, Egypt – 2012\nMaster's Degree in Student Affairs Management, Cairo University, Egypt – 2007\nBachelor's Degree in Education, Ain Shams University, Egypt – 2002",
            'experience' => "Vice Dean for Student Affairs, New Cairo Technological University\nStudent Services Coordinator, Cairo University (2015-2020)\nMember of the Egyptian Association for Student Development\nOrganizer of National Student Leadership Programs",
            'order' => 3,
        ]);
    }
}
