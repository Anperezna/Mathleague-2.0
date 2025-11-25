USE [master]
GO
/****** Object:  Database [MathLeague]    Script Date: 25/11/2025 15:57:26 ******/
CREATE DATABASE [MathLeague]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'MathLeague', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL16.MSSQLSERVER\MSSQL\DATA\MathLeague.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'MathLeague_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL16.MSSQLSERVER\MSSQL\DATA\MathLeague_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT, LEDGER = OFF
GO
ALTER DATABASE [MathLeague] SET COMPATIBILITY_LEVEL = 160
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [MathLeague].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [MathLeague] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [MathLeague] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [MathLeague] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [MathLeague] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [MathLeague] SET ARITHABORT OFF 
GO
ALTER DATABASE [MathLeague] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [MathLeague] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [MathLeague] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [MathLeague] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [MathLeague] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [MathLeague] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [MathLeague] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [MathLeague] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [MathLeague] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [MathLeague] SET  ENABLE_BROKER 
GO
ALTER DATABASE [MathLeague] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [MathLeague] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [MathLeague] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [MathLeague] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [MathLeague] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [MathLeague] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [MathLeague] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [MathLeague] SET RECOVERY FULL 
GO
ALTER DATABASE [MathLeague] SET  MULTI_USER 
GO
ALTER DATABASE [MathLeague] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [MathLeague] SET DB_CHAINING OFF 
GO
ALTER DATABASE [MathLeague] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [MathLeague] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [MathLeague] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [MathLeague] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'MathLeague', N'ON'
GO
ALTER DATABASE [MathLeague] SET QUERY_STORE = ON
GO
ALTER DATABASE [MathLeague] SET QUERY_STORE (OPERATION_MODE = READ_WRITE, CLEANUP_POLICY = (STALE_QUERY_THRESHOLD_DAYS = 30), DATA_FLUSH_INTERVAL_SECONDS = 900, INTERVAL_LENGTH_MINUTES = 60, MAX_STORAGE_SIZE_MB = 1000, QUERY_CAPTURE_MODE = AUTO, SIZE_BASED_CLEANUP_MODE = AUTO, MAX_PLANS_PER_QUERY = 200, WAIT_STATS_CAPTURE_MODE = ON)
GO
USE [MathLeague]
GO
/****** Object:  Table [dbo].[cache]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cache](
	[key] [nvarchar](255) NOT NULL,
	[value] [nvarchar](max) NOT NULL,
	[expiration] [int] NOT NULL,
 CONSTRAINT [cache_key_primary] PRIMARY KEY CLUSTERED 
(
	[key] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cache_locks]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cache_locks](
	[key] [nvarchar](255) NOT NULL,
	[owner] [nvarchar](255) NOT NULL,
	[expiration] [int] NOT NULL,
 CONSTRAINT [cache_locks_key_primary] PRIMARY KEY CLUSTERED 
(
	[key] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[failed_jobs]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[failed_jobs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[uuid] [nvarchar](255) NOT NULL,
	[connection] [nvarchar](max) NOT NULL,
	[queue] [nvarchar](max) NOT NULL,
	[payload] [nvarchar](max) NOT NULL,
	[exception] [nvarchar](max) NOT NULL,
	[failed_at] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[job_batches]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[job_batches](
	[id] [nvarchar](255) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[total_jobs] [int] NOT NULL,
	[pending_jobs] [int] NOT NULL,
	[failed_jobs] [int] NOT NULL,
	[failed_job_ids] [nvarchar](max) NOT NULL,
	[options] [nvarchar](max) NULL,
	[cancelled_at] [int] NULL,
	[created_at] [int] NOT NULL,
	[finished_at] [int] NULL,
 CONSTRAINT [job_batches_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[jobs]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[jobs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[queue] [nvarchar](255) NOT NULL,
	[payload] [nvarchar](max) NOT NULL,
	[attempts] [tinyint] NOT NULL,
	[reserved_at] [int] NULL,
	[available_at] [int] NOT NULL,
	[created_at] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[juegos]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[juegos](
	[id_juego] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](50) NOT NULL,
	[tipo_operacion] [varchar](50) NULL,
	[orden] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[id_juego] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[juegos_backup]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[juegos_backup](
	[id_juego] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](50) NOT NULL,
	[tipo_operacion] [varchar](50) NULL,
	[orden] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[juegos_sesion]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[juegos_sesion](
	[id_juegos_sesion] [int] IDENTITY(1,1) NOT NULL,
	[numero_nivel] [int] NULL,
	[level_length] [int] NULL,
	[completado] [bit] NULL,
	[errores_nivel] [int] NULL,
	[intentos_nivel] [int] NULL,
	[puntuacion] [int] NULL,
	[id_sesion] [int] NOT NULL,
	[id_juego] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id_juegos_sesion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[juegos_sesion_backup]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[juegos_sesion_backup](
	[id_juegos_sesion] [int] IDENTITY(1,1) NOT NULL,
	[numero_nivel] [int] NULL,
	[level_length] [int] NULL,
	[completado] [bit] NULL,
	[errores_nivel] [int] NULL,
	[intentos_nivel] [int] NULL,
	[puntuacion] [int] NULL,
	[id_sesion] [int] NOT NULL,
	[id_juego] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[migrations]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[migrations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[migration] [nvarchar](255) NOT NULL,
	[batch] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[opciones]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[opciones](
	[id_opcion] [int] IDENTITY(1,1) NOT NULL,
	[opcion1] [bit] NULL,
	[opcion2] [bit] NULL,
	[opcion3] [bit] NULL,
	[opcion4] [bit] NULL,
	[id_pregunta] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id_opcion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[opciones_backup]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[opciones_backup](
	[id_opcion] [int] IDENTITY(1,1) NOT NULL,
	[opcion1] [bit] NULL,
	[opcion2] [bit] NULL,
	[opcion3] [bit] NULL,
	[opcion4] [bit] NULL,
	[id_pregunta] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[password_reset_tokens]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[password_reset_tokens](
	[email] [nvarchar](255) NOT NULL,
	[token] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
 CONSTRAINT [password_reset_tokens_email_primary] PRIMARY KEY CLUSTERED 
(
	[email] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[preguntas]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[preguntas](
	[id_pregunta] [int] IDENTITY(1,1) NOT NULL,
	[nivel] [int] NULL,
	[enunciado] [varchar](255) NULL,
	[id_juego] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id_pregunta] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[preguntas_backup]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[preguntas_backup](
	[id_pregunta] [int] IDENTITY(1,1) NOT NULL,
	[nivel] [int] NULL,
	[enunciado] [varchar](255) NULL,
	[id_juego] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[sesiones]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sesiones](
	[id_sesion] [int] IDENTITY(1,1) NOT NULL,
	[date_time] [datetime] NOT NULL,
	[sesion_lenght] [int] NULL,
	[n_attemps] [int] NULL,
	[errores] [int] NULL,
	[points_scored] [int] NULL,
	[help_clicks] [int] NULL,
	[completado] [bit] NULL,
	[id_usuario] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id_sesion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[sesiones_backup]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sesiones_backup](
	[id_sesion] [int] IDENTITY(1,1) NOT NULL,
	[date_time] [datetime] NOT NULL,
	[sesion_lenght] [int] NULL,
	[n_attemps] [int] NULL,
	[errores] [int] NULL,
	[points_scored] [int] NULL,
	[help_clicks] [int] NULL,
	[completado] [bit] NULL,
	[id_usuario] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[sessions]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sessions](
	[id] [nvarchar](255) NOT NULL,
	[user_id] [bigint] NULL,
	[ip_address] [nvarchar](45) NULL,
	[user_agent] [nvarchar](max) NULL,
	[payload] [nvarchar](max) NOT NULL,
	[last_activity] [int] NOT NULL,
 CONSTRAINT [sessions_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[users]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[email_verified_at] [datetime] NULL,
	[password] [nvarchar](255) NOT NULL,
	[remember_token] [nvarchar](100) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[usuario]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[usuario](
	[id_usuario] [int] IDENTITY(1,1) NOT NULL,
	[username] [varchar](50) NOT NULL,
	[email] [varchar](50) NOT NULL,
	[contrasena] [varchar](200) NOT NULL,
	[fecha_registro] [datetime2](7) NOT NULL,
 CONSTRAINT [PK_Usuario] PRIMARY KEY CLUSTERED 
(
	[id_usuario] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[usuario_backup]    Script Date: 25/11/2025 15:57:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[usuario_backup](
	[id_usuario] [int] IDENTITY(1,1) NOT NULL,
	[username] [varchar](255) NOT NULL,
	[email] [varchar](255) NOT NULL,
	[contraseña] [varchar](255) NOT NULL,
	[fecha_registro] [datetime] NOT NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [failed_jobs_uuid_unique]    Script Date: 25/11/2025 15:57:27 ******/
CREATE UNIQUE NONCLUSTERED INDEX [failed_jobs_uuid_unique] ON [dbo].[failed_jobs]
(
	[uuid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [jobs_queue_index]    Script Date: 25/11/2025 15:57:27 ******/
CREATE NONCLUSTERED INDEX [jobs_queue_index] ON [dbo].[jobs]
(
	[queue] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
/****** Object:  Index [sessions_last_activity_index]    Script Date: 25/11/2025 15:57:27 ******/
CREATE NONCLUSTERED INDEX [sessions_last_activity_index] ON [dbo].[sessions]
(
	[last_activity] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
/****** Object:  Index [sessions_user_id_index]    Script Date: 25/11/2025 15:57:27 ******/
CREATE NONCLUSTERED INDEX [sessions_user_id_index] ON [dbo].[sessions]
(
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [users_email_unique]    Script Date: 25/11/2025 15:57:27 ******/
CREATE UNIQUE NONCLUSTERED INDEX [users_email_unique] ON [dbo].[users]
(
	[email] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
USE [master]
GO
ALTER DATABASE [MathLeague] SET  READ_WRITE 
GO
