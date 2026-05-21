<?php

namespace Database\Seeders;

use App\Models\Dean;
use App\Models\PresidentContent;
use Illuminate\Database\Seeder;

class InstitutionalManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed President Content
        PresidentContent::create([
            'full_name' => 'Professor Dr. Tarek Abdelmalak',
            'title' => 'Professor, Dr., PhD',
            'position' => 'President of New Cairo Technological University',
            'image' => null, // Will use default img/present.png from public folder
            'welcome_text' => "On behalf of all faculty members and their assistants at New Cairo Technological University (NCT), I warmly welcome you as new members of our university family.\nWe believe that true success is not limited to academics but also includes building character, developing skills, and broadening horizons.",
            'education' => "PhD (Mechanical Power Engineering), Shanghai University, China – 2002\nMaster's Degree (Mechanical Power Engineering), Cairo University, Egypt – 1996\nBachelor's Degree (Mechanical Power Engineering), Menoufia University, Egypt – 1991",
            'postdoctoral' => "2003-2005: Scientific mission at KAIST, South Korea\n2017: Short research visit at Kumamoto University, Japan",
            'administrative' => "Consultant at Niaf Paper Products Company (2005-2006)\nConsultant at Ramen Paper Products Company (2008-2012)\nProject Manager for Training Centers – Funded by Korean Government (2015-2017)\nMember of the Advisory Committee at the Science and Technology Development Fund (STDF)\nHonored as one of the Top Ten Directors of Technological Education Centers in Africa by the African Union (2015)",
        ]);

        // Seed Dean 1 - Industrial and Energy Technology
        Dean::create([
            'full_name' => 'Professor Dr. Walid Al-Khatam',
            'title' => 'Professor, Dr., PhD',
            'position' => 'Dean of the College of Industrial Technology and Energy',
            'faculty' => 'Faculty of Industrial and Energy Technology',
            'image' => null, // Will use default img/Dean1.png from public folder
            'welcome_text' => "We are pleased to welcome you to the Faculty of Industrial and Energy Technology, where we believe that education is the foundation for building a better future.\nOur faculty is committed to preparing highly qualified graduates who combine strong academic knowledge with practical skills that meet the needs of the labor market.\nWe strive to provide a modern and inspiring learning environment that encourages creativity and innovation.\nWe look forward to seeing our students become active partners in success and continuous development.",
            'education' => "Ph.D. in Electrical Engineering, University of Waterloo, Canada – June 2005\nMaster's Degree in Electrical Engineering (Power and Electrical Machines), Ain Shams University, Egypt – 1996\nBachelor's Degree in Electrical Engineering (Power and Electrical Machines), Ain Shams University, Egypt – 1996",
            'experience' => "Professor, Department of Electrical Power and Machines Engineering, Faculty of Engineering, Ain Shams University, Egypt.\nConsultant for Electricity and Renewable Energy Development Programs in Egypt and Arab countries (since 2014).\nTechnical Consultant, Energy Excellence Center, Faculty of Engineering, Ain Shams University (2021-2023)\nVice Chairman, IEEE Power Engineering Society (PES) – Egypt Chapter (2020 – 2022)\nDirector, Energy Excellence Center, Faculty of Engineering, Ain Shams University (2019 - 2021)",
            'order' => 1,
        ]);

        // Seed Dean 2 - Applied Health Sciences Technology
        Dean::create([
            'full_name' => 'Professor Dr. Mohammed Fawzi Al-Sawda',
            'title' => 'Professor, Dr., PhD',
            'position' => 'Dean of the College of Applied Health Sciences',
            'faculty' => 'Faculty of Applied Health Sciences Technology',
            'image' => null, // Will use default img/Dean2.png from public folder
            'welcome_text' => "We are delighted to welcome you to the Faculty of Applied Health Sciences Technology, where we are dedicated to advancing education and training in the vital fields of health sciences.\nOur faculty aims to prepare competent graduates who combine scientific knowledge with practical skills to serve the community and meet the needs of the healthcare sector.\nWe are committed to providing a supportive and innovative learning environment that promotes excellence, ethics, and continuous improvement.",
            'education' => "Under Construction",
            'experience' => "Under Construction",
            'order' => 2,
        ]);

        // Seed Dean 3 - Students Affairs Vice Dean
        Dean::create([
            'full_name' => 'Prof. Dr. Tamer Abouelnaga',
            'title' => 'Professor, Dr., PhD',
            'position' => 'Students Affairs Vice Dean of College of Industry and Energy Technology',
            'faculty' => 'College of Industry and Energy Technology',
            'image' => null, // Will use default img/ViseDean.png from public folder
            'welcome_text' => "The Students Affairs Vice Dean of the College of Industry and Energy Technology is committed to supporting students academically and personally. The office works to enhance student engagement, ensure academic guidance, and promote a positive learning environment.\nContinuous efforts are made to empower students and prepare them for professional success.",
            'education' => "Ph.D. in Communications and Electronics Engineering. Ain Shams University, Egypt, 2012\nDissertation: Design and Implementation of Radio Frequency Identification (RFID) Antennas\n\nM.Sc. in Communications and Electronics Engineering. Ain Shams University, Egypt, 2007\nThesis: Field Theory Analysis of Microwave Dielectric Resonator Antennas\n\nB.Sc. in Electrical Engineering (Communications & Electronics).\nFaculty of Electronic Engineering, Menoufia University, Egypt, 1999 (Very Good with Honors)",
            'experience' => "Academic & Administrative Positions:\n\n• Students Affairs Vice Dean, College of Industry and Energy Technology, New Cairo Technological University (NCTU) (2022–2026)\n• Vice Dean for Community Service and Environmental Development, Higher Institute of Engineering and Technology, Kafr El‑Sheikh (2020–2022)\n• Students Affairs Vice Dean of Higher Institute of Engineering and Technology – Kafr Elsheikh City – Ministerial decision No. 1445- 23-4-2019\n• Professor: Electronics Research Institute- Ministry of Higher Education and Scientific Research (2-1-2024: Till now)\n• Associate Professor: Electronics Research Institute- Ministry of Higher Education and Scientific Research (14-3-2018: 1-1-2024)\n• Researcher: Electronics Research Institute- Ministry of Higher Education and Scientific Research (14-8-2012: 13-3-2018)\n• Assistant Researcher: Electronics Research Institute- Ministry of Higher Education and Scientific Research (10-9-2007: 13-8-2012)\n• Researcher Assistant: Electronics Research Institute- Ministry of Higher Education and Scientific Research (24-3-2001: 9-9-2007)\n• Associate Professor: Higher institute of engineering and technology - Ministry of Higher Education and Scientific Research (2018- 2022)\n\nTeaching Experience:\n\n2003–2014 | American University in Cairo (AUC).\nComputer Architecture (Course 339); Graduation Project – Cube Satellite (RF Transceiver & Antenna Design)\n\n2015–2022 | Higher Institute of Engineering and Technology, Kafr El-Sheikh.\nElectromagnetic Fields; Electronics; RF Power Amplifier; Antennas and Wave Propagation\n\n2021–2022 | Suez University, Faculty of Industrial Education.\nIntegrated Circuits Design; Electronic Circuits II\n\n2015–2016 | Akhbar El-Yom Academy\nElectronic Devices; Digital Circuits (I)\n\n2012–2014 | Al-Azhar University\nMicrowave Engineering; Electromagnetics\n\n2013–2015 | Integrated Thebes Institutes\nAcoustics; Antennas; Microwave Engineering; Electromagnetic Theory\n\n2019–2020 | Kafr Elsheikh University, Faculty of Engineering\nElectronic Engineering; Electromagnetic Fields\n\n2022–2026 | New Cairo Technological University, Faculty of Industry and Energy Technology\nProgramming using MATLAB; Embedded Systems; Analog and Digital Electronics\n\nThesis Supervisions:\n\nM.Sc. | Faculty of Engineering, Ain Shams University\nNovel Antenna Array System for Recent Radar Applications\n\nM.Sc. | Faculty of Engineering, Alexandria University\nBreast Cancer Early Detection\n\nM.Sc. | Faculty of Engineering, Alexandria University\nA Proposed Antennas Design and Implementation for Noninvasive Localized Breast Tumor Treatment using Microwave Hyperthermia\n\nPh.D. | Egypt-Japan University of Science and Technology (E-JUST)\nBreast Cancer Hyperthermia Treatment\n\nPh.D. | Faculty of Engineering, Aswan University\n5G Mobile Antennas\n\nPh.D. | Faculty of Engineering, Aswan University\nImplanted Antennas\n\nPh.D. | Faculty of Electronics Engineering, Menoufia University\nDesign of MIMO Antenna Array for 5G Systems\n\nPh.D. | Suez University\nEnhancing CMOS Power Amplifier Efficiency and Linearity Techniques for 5G Network Applications\n\nPh.D. | Faculty of Engineering, Ain Shams University\nMulti-static Ground-Based Arc Synthetic Aperture Radar (GB-A-SAR)\n\nPh.D. | Faculty of Engineering, Alexandria University\nBreast Tumor Diagnosis Using Microwave Imaging\n\nResearch Interests:\n\n• Microwave and RF Engineering\n• Antenna Design (UWB, MIMO, RFID, Biomedical Antennas)\n• Electromagnetic Modeling and Full‑Wave Analysis\n• Ground Penetrating Radar (GPR)\n• 5G and Sub‑6 GHz Wireless Systems\n• Biomedical Microwave Applications",
            'order' => 3,
        ]);
    }
}
